const { Cluster } = require('puppeteer-cluster');
const puppeteer = require('puppeteer');

(async () => {
    const cluster = await Cluster.launch({
        concurrency: Cluster.CONCURRENCY_CONTEXT,
        maxConcurrency: 1,
        puppeteerOptions: {
            headless: "new",
            executablePath: '/usr/bin/google-chrome-stable',
            args: [
                "--no-sandbox",
                "--disable-setuid-sandbox",
                "--disable-blink-features=AutomationControlled",
                '--disable-web-security',
                '--disable-features=IsolateOrigins,site-per-process',
                '--disable-features=SameSiteByDefaultCookies,CookiesWithoutSameSiteMustBeSecure',
                '--disk-cache-size=0',
                '--disable-cache',
            ],
        },
    });

    const cookieString = process.argv[3];

    const cookies = cookieString.split('; ').map(cookie => {
        const [name, value] = cookie.split('=');
        return { name, value, domain: '.instagram.com' };
    });

    await cluster.task(async ({ page, data: username }) => {
        const url = `https://www.instagram.com/api/v1/users/web_profile_info/?username=${username}`;
        let jsonResponse = null;
        let htmlResponse = null;

        try {
            await page.setUserAgent(
                'Instagram 86.0.0.24.87 Android (15/1.4.3; 420; 411.4/890.2; google; sdk_gphone64_x86_64; sdk_gphone64_x86_64; emu64xa; en_US)'
            );
            await page.setExtraHTTPHeaders({ 'Accept-Language': 'en-US,en;q=0.9' });
            await page.setCookie(...cookies);
            await page.setCacheEnabled(false);
            await page.setRequestInterception(true);
            page.on('request', req => req.continue());

            page.on('response', async res => {
                if (res.url().includes('/api/v1/users/web_profile_info/')) {
                    const contentType = res.headers()['content-type'] || '';
                    if (contentType.includes('application/json')) {
                        try {
                            jsonResponse = await res.json();
                        } catch (err) {
                            jsonResponse = {
                                success: false,
                                username,
                                error: "JSON parse error",
                                raw: await res.text()
                            };
                        }
                    } else if (contentType.includes('text/html')) {
                        htmlResponse = await res.text();
                    }
                }
            });

            await page.goto(url, { waitUntil: 'networkidle2' });

            // Validate expired cookie
            if (jsonResponse && jsonResponse.require_login === true) {
                console.log(JSON.stringify({
                    success: false,
                    username,
                    code: 900,
                    error: "Cookies expired or invalid"
                }));
                return;
            }

            // Validate invalid username (HTML 404)
            if (htmlResponse && htmlResponse.includes('Page Not Found')) {
                console.log(JSON.stringify({
                    success: false,
                    username,
                    code: 835,
                    error: "Username not found"
                }));
                return;
            }

            // Valid user data
            if (jsonResponse && jsonResponse.data && jsonResponse.data.user) {
                console.log(JSON.stringify({
                    success: true,
                    username,
                    data: jsonResponse.data
                }));
            } else {
                // Catch-all error
                console.log(JSON.stringify({
                    success: false,
                    username,
                    code: 455,
                    error: 'No user data found or unknown error'
                }));
            }

        } catch (error) {
            console.log(JSON.stringify({
                success: false,
                username,
                code: 455,
                error: error.message
            }));
        }
    });

    const username = process.argv[2];

    if (!username) {
        console.log(JSON.stringify({ success: false, error: "No username provided!" }));
        process.exit(1);
    }

    await cluster.queue(username);
    await cluster.idle();
    await cluster.close();
})();
