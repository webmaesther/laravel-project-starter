import { expect, test } from '@playwright/test';

test.describe('Home Page', () => {
    test('has title', async ({ page }) => {
        await page.goto('https://laravel-project-starter.test');

        await expect(page.getByRole('heading')).toContainText('Laravel Project Starter');
    });
});
