import { Builder, By, until } from 'selenium-webdriver';
import chrome from 'selenium-webdriver/chrome.js';

const BASE_URL = 'https://www.musimundo.com/Promociones_Bancarias_Vigentes';

async function scrapeTextFromSpans(driver) {
    try {
        await driver.get(BASE_URL);
        await driver.sleep(5000); // espera 5 segundos
        await driver.wait(until.elementLocated(By.css('.yCmsComponent span')), 10000);

        const yCmsComponents = await driver.findElements(By.css('.yCmsComponent span'));
        const promotionsText = [];

        for (let component of yCmsComponents) {
            const text = await component.getText();
            // Filtrar solo los textos que comiencen con '#'
            if (text.startsWith('#')) {
                promotionsText.push(text.trim());
            }
        }

        console.log(promotionsText);
    } catch (error) {
        console.error('An error occurred while scraping text from spans:', error);
    }
}

(async function scrape() {
    const driver = await new Builder()
        .forBrowser('chrome')
        .setChromeOptions(new chrome.Options().windowSize({ width: 1920, height: 1080 }))
        .build();

    try {
        await scrapeTextFromSpans(driver);
    } finally {
        await driver.quit();
    }
})();
