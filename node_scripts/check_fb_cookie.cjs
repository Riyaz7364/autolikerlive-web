const { Cluster } = require('puppeteer-cluster');
const puppeteer = require('puppeteer');

(async () => {
    const cluster = await Cluster.launch({
        concurrency: Cluster.CONCURRENCY_CONTEXT,
        maxConcurrency: 5,
        puppeteerOptions: {
            headless: "new",
            executablePath: '/usr/bin/google-chrome-stable',
            args: [
                "--no-sandbox",
                "--disable-setuid-sandbox",
                "--disable-blink-features=AutomationControlled",
                "--disable-web-security",
                "--disable-features=IsolateOrigins,site-per-process",
                "--disable-features=SameSiteByDefaultCookies,CookiesWithoutSameSiteMustBeSecure",
                "--disk-cache-size=0",
                "--disable-cache",
            ],
        },
    });

    const cookiesList = JSON.parse(process.argv[2]); // array of strings
    const results = [];

    cookiesList.forEach((cookieString, index) => {
        cluster.queue(async ({ page }) => {
            const cookies = cookieString
                .split(';')
                .map(cookie => cookie.trim())
                .filter(cookie => cookie.includes('='))
                .map(cookie => {
                    const [name, ...valParts] = cookie.split('=');
                    return {
                        name: name.trim(),
                        value: valParts.join('=').trim(),
                        domain: '.facebook.com',
                        path: '/',
                    };
                });

            try {
                await page.setCookie(...cookies);
                await page.setRequestInterception(true);
                page.on('request', req => {
                    const type = req.resourceType();
                    if (['image', 'stylesheet', 'font', 'media', 'xhr', 'fetch'].includes(type)) {
                        req.abort();
                    } else {
                        req.continue();
                    }
                });

                await page.goto('https://www.facebook.com', { waitUntil: 'domcontentloaded' });

                const isLoggedIn = await page.evaluate(() => {
                    return !document.querySelector('button[name="login"]');
                });

                results.push({
                    cookieIndex: index,
                    success: isLoggedIn,
                    status: isLoggedIn ? 200 : 401

                });

            } catch (e) {
                results.push({
                    cookieIndex: index,
                    error: e.message
                });
            }
        });
    });

    await cluster.idle();
    await cluster.close();

    // Output everything once
    console.log(JSON.stringify({
        success: true,
        total: cookiesList.length,
        results
    }));
})();
