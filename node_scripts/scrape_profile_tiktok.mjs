// scrape_tiktok_user.cjs
import fetch from 'node-fetch';
import xbogus from 'xbogus';
import { randomBytes } from 'crypto';

async function safeFetch(url, options, retries = 3) {
    for (let i = 0; i < retries; i++) {
        try {
            return await fetch(url, options);
        } catch (err) {
            if (i === retries - 1) throw err;
            await new Promise(res => setTimeout(res, 500 * (i + 1))); // Wait before retry
        }
    }
}

async function getUser(username) {
    const ua =
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';

    // 1️⃣ Build the unsigned path (no host, no cookies yet)
    const path =
        `/api/user/detail/?uniqueId=${encodeURIComponent(username)}` +
        '&device_platform=web_pc&aid=1988&app_language=en&region=NL';

    // 2️⃣ Generate X-Bogus from full URL + UA
    const xb = xbogus(`https://www.tiktok.com${path}`, ua);

    // 3️⃣ Fake but well-formed msToken (can be anything 16–32 bytes base64)
    const msToken = randomBytes(16).toString('base64');

    // 4️⃣ Final URL
    const url = `https://www.tiktok.com${path}&X-Bogus=${xb}&msToken=${encodeURIComponent(msToken)}`;

    const res = await fetch(url, {
        headers: {
            'User-Agent': ua,
            'Referer': `https://www.tiktok.com/@${username}`,
            'Accept': 'application/json, text/plain, */*',
            'Accept-Language': 'en-US,en;q=0.9',
            'Sec-Fetch-Site': 'same-origin',
            'Sec-Fetch-Mode': 'cors',
            'Sec-Fetch-Dest': 'empty',
            'Connection': 'keep-alive',
            'Cookie': `msToken=${msToken};`
        }
    });

    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
}

// Command-line usage: node scrape_tiktok_user.cjs <username>
if (process.argv[2]) {
    getUser(process.argv[2])
        .then((j) => console.log(JSON.stringify(j, null, 2)))
        .catch(console.error);
} else {
    console.error('Usage: node scrape_tiktok_user.cjs <username>');
    process.exit(1);
}
