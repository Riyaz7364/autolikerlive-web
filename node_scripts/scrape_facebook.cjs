const { Cluster } = require("puppeteer-cluster");
const puppeteer = require("puppeteer");
const fs = require("fs");
const path = require("path");
const cheerio = require("cheerio");

// Search for key with child count > minChildren
function findObjectsWithMinChildren(
    obj,
    targetKey,
    minChildren = 5,
    results = []
) {
    if (typeof obj !== "object" || obj === null) return results;

    for (const key in obj) {
        const value = obj[key];
        if (
            key === targetKey &&
            typeof value === "object" &&
            Object.keys(value).length > minChildren
        ) {
            results.push(value);
        }
        if (typeof value === "object") {
            findObjectsWithMinChildren(value, targetKey, minChildren, results);
        }
    }

    return results;
}

function findValuesByKeys(obj, keys, result = {}) {
    if (typeof obj !== "object" || obj === null) return result;

    for (const key in obj) {
        const value = obj[key];
        if (keys.includes(key) && result[key] === undefined) {
            result[key] = value;
        }
        if (typeof value === "object") {
            findValuesByKeys(value, keys, result);
        }
    }

    return result;
}

(async () => {
    // Get command line arguments
    const urlPath = process.argv[2];
    const searchKey = process.argv[3];
    const singleValue = process.argv[4];
    const minLength = parseInt(process.argv[5]);

    if (!urlPath || !searchKey || isNaN(minLength)) {
        console.error(
            "Usage: node script.js <url_path> <json_key1,json_key2,...> <min_child_count>"
        );
        process.exit(1);
    }

    const searchKeys = searchKey.split(",").map((k) => k.trim());
    const singleValues = singleValue.split(",").map((k) => k.trim());

    const cluster = await Cluster.launch({
        concurrency: Cluster.CONCURRENCY_CONTEXT,
        maxConcurrency: 1,
        puppeteerOptions: {
            headless: "new",
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
        },
    });

    const cookieString =
        "datr=KPHhaPdLwziEMfFWwEts5uS7; sb=KPHhaLWGJZfVqa7t8WasntON; wd=784x739";
    const cookies = cookieString.split("; ").map((cookie) => {
        const [name, value] = cookie.split("=");
        return { name, value, domain: ".facebook.com" };
    });

    await cluster.task(async ({ page }) => {
        const url = `https://www.facebook.com/${urlPath}`;
        let htmlResponse = null;

        try {
            await page.setUserAgent(
                "Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion"
            );
            await page.setExtraHTTPHeaders({
                "Accept-Language": "en-US,en;q=0.9",
            });
            await page.setCookie(...cookies);
            await page.setCacheEnabled(false);
            await page.setRequestInterception(true);
            page.on("request", (req) => req.continue());

            page.on("response", async (res) => {
                const contentType = res.headers()["content-type"] || "";
                if (contentType.includes("text/html")) {
                    try {
                        htmlResponse = await res.text();
                    } catch (err) {
                        console.error(
                            "Error reading HTML response:",
                            err.message
                        );
                    }
                }
            });

            await page.goto(url, { waitUntil: "networkidle2" });

            if (htmlResponse) {
                const $ = cheerio.load(htmlResponse);
                let resultsPerKey = {};
                let matched = false;
                $('script[type="application/json"][data-sjs]').each((i, el) => {
                    const jsonText = $(el).html();
                    try {
                        const data = JSON.parse(jsonText);

                        for (const rawKey of searchKeys) {
                            const isMulti = rawKey.endsWith("-multi");
                            const key = isMulti ? rawKey.slice(0, -6) : rawKey; // remove "-multi" from end

                            if (!resultsPerKey[rawKey]) {
                                const matches = findObjectsWithMinChildren(
                                    data,
                                    key,
                                    minLength
                                );
                                if (matches.length > 0) {
                                    resultsPerKey[rawKey] = isMulti
                                        ? matches
                                        : matches[0];
                                    matched = true;
                                }
                            }
                        }

                        // Single value keys (also go into resultsPerKey)
                        for (const key of singleValues) {
                            if (!resultsPerKey[key]) {
                                const found = findValuesByKeys(data, [key]);
                                if (found[key] !== undefined) {
                                    resultsPerKey[key] = found[key]; // insert single value
                                    matched = true;
                                }
                            }
                        }
                    } catch (err) {
                        console.log(
                            JSON.stringify({
                                success: false,
                                username: urlPath,
                                code: 500,
                                error: "JSON parsing error: " + err.message,
                            })
                        );
                    }
                });

                if (matched) {
                    console.log(
                        JSON.stringify({
                            success: true,
                            username: urlPath,
                            code: 200,
                            data: resultsPerKey,
                        })
                    );
                    // fileName = `facebook_post_${Date.now()}.json`;
                    // const filePath = path.join(__dirname, '../storage/app/public/', fileName);
                    // fs.writeFileSync(filePath, JSON.stringify(resultsPerKey, null, 2), 'utf-8');
                } else {
                    console.log(
                        JSON.stringify({
                            success: false,
                            username: urlPath,
                            code: 204,
                            error: "Invalid username/ID \r\n or Private Account",
                        })
                    );
                }
            } else {
                console.log(
                    JSON.stringify({
                        success: false,
                        username: urlPath,
                        code: 404,
                        error: "No response captured",
                    })
                );
            }
        } catch (error) {
            console.log(
                JSON.stringify({
                    success: false,
                    code: 455,
                    error: error.message,
                })
            );
        }
    });

    await cluster.queue();
    await cluster.idle();
    await cluster.close();
})();
