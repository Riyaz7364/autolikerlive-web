#!/usr/bin/env node
const puppeteer = require("puppeteer");

class WebController {
    async config() {
        return await puppeteer.launch({
            executablePath: "/usr/bin/google-chrome-stable",
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
            headless: true,
        });
    }

    async setCookies(page) {
        const api = "https://www.autolikerlive.com/api/getCookies";
        const response = await fetch(api);
        const data = await response.json();

        const cookieString = data?.cookies || "";
        if (!cookieString) {
            console.warn("No cookies were returned from API.");
            return;
        }

        const cookies = cookieString.split("; ").map((cookie) => {
            const [name, value] = cookie.split("=");
            return { name, value, domain: ".facebook.com" };
        });

        await page.setCookie(...cookies);
    }

    async navigateSafely(page, link) {
        try {
            const response = await page.goto(link, {
                waitUntil: "domcontentloaded",
                timeout: 15000,
            });

            if (!response) {
                throw new Error(`Response was null for ${link}`);
            }

            const status = response.status();
            if (status >= 400) {
                throw new Error(`HTTP Status Code: ${status}`);
            }
        } catch (error) {
            const message = error?.message || String(error);
            if (message.includes("ERR_NAME_NOT_RESOLVED")) {
                console.error(`[ERROR] Invalid Link/DNS Failure: ${link}`);
            } else if (message.includes("Timeout")) {
                console.error(`[ERROR] Navigation Timeout: ${link}`);
            } else {
                console.error(
                    `[ERROR] Navigation failed unexpectedly: ${message}`,
                );
            }
            throw error;
        }
    }

    async getFinalUrl(page, link) {
        try {
            // await this.setCookies(page);
            await this.navigateSafely(page, link);
            const url = page.url();
            return link.includes("share/p") ? (url === link ? null : url) : url;
        } finally {
            await page.close();
        }
    }

    async main(link) {
        const browser = await this.config();
        try {
            const page = await browser.newPage();
            const url = await this.getFinalUrl(page, link);

            if (url && url.includes("login/?next=")) {
                const nextUrl = new URL(url);
                const nextParam = nextUrl.searchParams.get("next");
                return nextParam ? decodeURIComponent(nextParam) : url;
            }

            return url;
        } finally {
            await browser.close();
        }
    }
}

async function runCli() {
    const [link] = process.argv.slice(2);
    if (!link || ["-h", "--help"].includes(link)) {
        console.error("Usage: node node_scripts/get_final_url.cjs <url>");
        process.exit(link ? 0 : 1);
    }

    const controller = new WebController();
    try {
        const finalUrl = await controller.main(link);
        if (finalUrl) {
            console.log(finalUrl);
            process.exit(0);
        }
        console.log("");
        process.exit(1);
    } catch (error) {
        console.error("Failed to resolve final URL:", error);
        process.exit(1);
    }
}

if (require.main === module) {
    runCli();
}
