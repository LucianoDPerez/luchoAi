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

        await page.goto('https://www.musimundo.com/super-ofertas/c/superofertas', { waitUntil: 'networkidle0', timeout: 60000 });

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

        await page.waitForSelector('.mus-product-box', { timeout: 60000 }); // Esperar a que se cargue la sección de productos

        const productsElements = await page.$$('.mus-product-box'); // Buscar elementos de productos
        let productsInfo = [];

        for (let productElement of productsElements) {
            // Verificar si el atributo data-product existe antes de intentar obtener su valor
            const productData = await productElement.evaluate(el => el.getAttribute('data-product'));
            if (productData) {
                try {
                    const productJson = JSON.parse(productData);
                    // Extraer la información del producto
                    productsInfo.push({
                        title: productJson.name,
                        price: productJson.price.formattedValue.replace(/,/g, ''),
                        url: productJson.url,
                        description: productJson.description,
                        images: productJson.images[0].url // URL de la imagen principal
                    });
                } catch (e) {
                    console.error('Error parsing product JSON:', e);
                }
            }
        }

        console.log(JSON.stringify(productsInfo, null, 2));
    } catch (error) {
        console.error('An error occurred:', error);
    } finally {
        await browser.close();
    }
})();
