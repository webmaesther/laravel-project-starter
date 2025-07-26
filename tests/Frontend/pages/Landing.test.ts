import Landing from '@/pages/Landing.vue';
import { render, screen} from '@testing-library/vue';
import { describe, expect, test } from 'vitest';
import { login } from '@/routes';

describe('<Landing />', () => {

    test('renders Laravel as text', async () => {
        render(Landing);

        expect(screen.queryByText('Laravel Project Starter', { exact: false })).not.toBeNull();
    });

    test('renders a Login link', async () => {
        render(Landing)

        screen.getByRole('link', {name: 'Login'}).click();

        expect(window.location.href).toContain(login.url());
    });
});
