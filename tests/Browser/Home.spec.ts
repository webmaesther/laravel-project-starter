import { home } from '@/routes';
import { expect, test } from '@playwright/test';

test.describe('Home Page', () => {
    test('has title', async ({ page }) => {
        await page.goto(home.url());

        await expect(page.getByRole('heading', { level: 1 })).toContainText('Laravel Project Starter');
    });
});
