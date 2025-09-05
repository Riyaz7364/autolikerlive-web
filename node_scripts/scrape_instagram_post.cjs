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

    const mediaId = process.argv[2];
    const cookieString = process.argv[3];

    if (!mediaId || !cookieString) {
        console.log(JSON.stringify({
            success: false,
            code: 901,
            error: "Media ID or Cookies not provided"
        }));
        process.exit(1);
    }

    const cookies = cookieString.split('; ').map(cookie => {
        const [name, value] = cookie.split('=');
        return { name, value, domain: '.instagram.com' };
    });

    await cluster.task(async ({ page, data }) => {
        const url = `https://www.instagram.com/api/v1/media/${data}/info/`;

        try {
            await page.setUserAgent(
                'Instagram 86.0.0.24.87 Android (15/1.4.3; 420; 411.4/890.2; google; sdk_gphone64_x86_64; sdk_gphone64_x86_64; emu64xa; en_US)'
            );
            await page.setExtraHTTPHeaders({ 'Accept-Language': 'en-US,en;q=0.9' });

            await page.setCookie(...cookies);
            await page.setCacheEnabled(false);
            await page.setRequestInterception(true);
            page.on('request', req => req.continue());

            let jsonResponse = null;

            page.on('response', async res => {
                if (res.url().includes(`/api/v1/media/${data}/info/`)) {
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
            if ((jsonResponse && jsonResponse.hasOwnProperty('challenge')) || jsonResponse.require_login === true ) {
                console.log(JSON.stringify({
                    success: false,
                    media_id: data,
                    code: 900,
                    error: "Cookies expired or invalid"
                }));
                return;
            }

            // Handle valid response
            if (jsonResponse && jsonResponse.items && jsonResponse.num_results > 0) {
                console.log(JSON.stringify({
                    success: true,
                    media_id: data,
                    data: jsonResponse.items[0]
                }));
            }
            // Handle known invalid media ID
            else if (jsonResponse?.message?.includes('Invalid media_id')) {
                console.log(JSON.stringify({
                    success: false,
                    code: 835,
                    media_id: data,
                    error: "Invalid media ID"
                }));
            }
            else {
                console.log(JSON.stringify({
                    success: false,
                    code: 903,
                    media_id: data,
                    // data: jsonResponse.hasOwnProperty('challenge'),
                    error: "Media not found or unknown error"
                }));
            }

        } catch (error) {
            console.log(JSON.stringify({
                success: false,
                code: 500,

                media_id: data,
                error: error.message
            }));
        }
    });

    await cluster.queue(mediaId);
    await cluster.idle();
    await cluster.close();
})();
