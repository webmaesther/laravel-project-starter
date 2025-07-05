import Landing from '@/pages/Landing.vue';
import { render, screen } from '@testing-library/vue';
import { describe, expect, test } from 'vitest';

describe('<Landing />', () => {
    test('renders Laravel on the page', async () => {
        render(Landing);

        expect(screen.queryByText('Laravel', { exact: false })).not.toBeNull();
    });
});
