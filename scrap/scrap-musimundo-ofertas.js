import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

(async function example() {
    // Configurar las opciones de Chrome
    const chromeOptions = new chrome.Options();
        chromeOptions.addArguments(['--window-size=1920,1080', '--disable-infobars', '--disable-gpu', '--incognito']); // Establecer el tamaño de la ventana
        chromeOptions.addArguments(['--disable-infobars']); // Deshabilitar la notificación de automatización

    //chromeOptions.addArguments(['--headless', '--disable-infobars', '--disable-gpu', '--no-sandbox', '--disable-dev-shm-usage']);

    let driver = await new Builder()
        .forBrowser('chrome')
        .setChromeOptions(chromeOptions)
        .build();

    try {
        await driver.get('https://www.musimundo.com/super-ofertas/c/superofertas');
        await driver.wait(until.elementLocated(By.css('.mus-product-box')), 120000); // Esperar a que se cargue la sección de productos

        const productsElements = await driver.findElements(By.css('.mus-product-box')); // Buscar elementos de productos
        let productsInfo = [];

        for (let productElement of productsElements) {
            // Verificar si el atributo data-product existe antes de intentar obtener su valor
            const productData = await productElement.getAttribute('data-product');
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
            } //else {
               // console.log('No product data found for an element.');
           // }
        }

        console.log(JSON.stringify(productsInfo, null, 2));
    } catch (error) {
        console.error('An error occurred:', error);
    } finally {
        await driver.quit();
    }
})();
