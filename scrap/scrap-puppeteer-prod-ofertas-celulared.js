import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';

puppeteer.use(StealthPlugin());

(async function example() {
    // Configurar las opciones de Chrome
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

        await page.goto('https://www.musimundo.com/super-ofertas/c/superofertas?q=%3Arelevance%3Acategory%3A85&show=All', { waitUntil: 'networkidle0', timeout: 15000 });

        // Espera aleatoria
        await new Promise(resolve => setTimeout(resolve, 750 + Math.random() * 500));

        // Simular scroll
        await page.evaluate(() => {
            window.scrollTo(0, document.body.scrollHeight);
        });

        // Otra espera aleatoria
        await new Promise(resolve => setTimeout(resolve, 750 + Math.random() * 500));

        await page.waitForSelector('.mus-product-box', { timeout: 15000 }); // Esperar a que se cargue la sección de productos

        const productsElements = await page.$$('.mus-product-box'); // Buscar elementos de productos
        let productsInfo = [];

        for (let productElement of productsElements) {
            try {
                const title = await productElement.$eval('.mus-pro-name', el => el.textContent.trim());
                const price = await productElement.$eval('.mus-pro-price-number', el => el.textContent.trim());
                const url = await productElement.$eval('a', el => el.href);
                const image = await productElement.$eval('a img#productMainImage', el => el.src);

                productsInfo.push({
                    title,
                    price,
                    url,
                    image
                });
            } catch (e) {
                console.error('Error obteniendo información del producto:', e);
            }
        }

        console.log(JSON.stringify(productsInfo, null, 2));

    } catch (error) {
        console.error('An error occurred:', error);
    } finally {
        await browser.close();
    }
})();
