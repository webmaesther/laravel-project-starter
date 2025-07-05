import Home from '@/pages/Home.vue';
import { render, screen } from '@testing-library/vue';
import { describe, expect, test } from 'vitest';

describe('<Home />', () => {
    test('it displays the app name', () => {
        render(Home, {
            global: {
                mocks: {
                    $page: {
                        props: {
                            name: 'App Name',
                        },
                    },
                },
            },
        });

        expect(screen.queryByText('App Name', { exact: true })).not.toBeNull();
    });
});
