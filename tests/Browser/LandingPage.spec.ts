import { landing, login } from '@/routes';
import { expect, test } from '@playwright/test';

test.describe('Home Page', () => {
    test('shows the title', async ({ page }) => {
        await page.goto(landing.url());

        await expect(page.getByRole('heading')).toContainText('Laravel Project Starter');
    });

    test('shows a link to login', async ({page}) => {
        await page.goto(landing.url());

        await page.getByRole('link', {name: 'Login'}).click();
        await page.waitForURL(login.url());

        expect(page.url()).toContain(login.url());
    })
});
