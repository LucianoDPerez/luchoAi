import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';

puppeteer.use(StealthPlugin());

async function scrapeCategories() {
    const browser = await puppeteer.launch({
        headless: "new",
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    });
    const page = await browser.newPage();

    try {
        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

        await page.goto('https://www.musimundo.com/super-ofertas/c/superofertas', { waitUntil: 'networkidle0', timeout: 15000 });

        const categories = await page.$$eval('.allFacetValues li', (lis) => {
            return lis.map((li) => {
                const a = li.querySelector('a');
                const text = a.textContent.trim().replace(/\s*\(\d+\)/, '');
                const href = a.href;
                const match = href.match(/\?q=.*category%3A(\d+)/);
                if (match) {
                    const categoryId = match[1];
                    return { text, categoryId, url: href };
                } else {
                    return null;
                }
            }).filter(Boolean);
        });

        console.log('categories:', categories);
    } catch (error) {
        console.error('An error occurred while scraping categories:', error);
    } finally {
        await browser.close();
    }
}

scrapeCategories();
