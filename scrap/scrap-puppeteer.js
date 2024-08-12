import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';

puppeteer.use(StealthPlugin());

const BASE_URL = 'https://www.musimundo.com/Promociones_Bancarias_Vigentes';

async function scrapeTextFromSpans() {
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

        await page.goto(BASE_URL, { waitUntil: 'networkidle0', timeout: 60000 });

        // Espera aleatoria
        await new Promise(resolve => setTimeout(resolve, 5000 + Math.random() * 5000));

        // Simular scroll
        await page.evaluate(() => {
            return new Promise((resolve) => {
                let totalHeight = 0;
                const distance = 100;
                const timer = setInterval(() => {
                    window.scrollBy(0, distance);
                    totalHeight += distance;
                    if(totalHeight >= document.body.scrollHeight){
                        clearInterval(timer);
                        resolve();
                    }
                }, 200);
            });
        });

        // Otra espera aleatoria
        await new Promise(resolve => setTimeout(resolve, 3000 + Math.random() * 2000));

        const promotionsText = await page.evaluate(() => {
            const allText = document.body.innerText;
            const lines = allText.split('\n');
            return lines
                .filter(line => line.includes('#'))
                .map(line => line.trim())
                .filter(line => line.length > 0);
        });

        console.log(promotionsText);
    } catch (error) {
        console.error('An error occurred while scraping text from spans:', error);
    } finally {
        await browser.close();
    }
}

scrapeTextFromSpans();
