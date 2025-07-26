import { createHeadManager } from '@inertiajs/core';
import { config } from '@vue/test-utils';
import { afterEach, vi } from 'vitest';
import { cleanup } from '@testing-library/vue';
import { router } from '@inertiajs/vue3';

config.global.mocks.$headManager = createHeadManager(
    false,
    (title) => title,
    () => {},
);

afterEach(() => {
    cleanup();
});

vi.spyOn(router, 'visit')
    .mockImplementation(vi.fn((url) => {
    window.location.href = url;
    return Promise.resolve();
}));
