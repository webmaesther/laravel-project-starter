import Welcome from '@/pages/Home.vue';
import { render, screen } from '@testing-library/vue';
import { describe } from 'node:test';
import { expect, test } from 'vitest';

describe('<Welcome />', () => {
    test('renders Laravel on the page', async () => {
        render(Welcome);

        expect(screen.queryByText('Laravel', { exact: false })).not.toBeNull();
    });
});
