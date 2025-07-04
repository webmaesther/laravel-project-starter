import { landing } from '@/routes';
import { expect, test } from '@playwright/test';

test.describe('Landing Page', () => {
    test('has title', async ({ page }) => {
        await page.goto(landing.url());

        await expect(page.getByRole('heading', { level: 1 })).toContainText('Laravel Project Starter');
    });
});
