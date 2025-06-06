import { createHeadManager } from '@inertiajs/core';
import { config } from '@vue/test-utils';

config.global.mocks.$headManager = createHeadManager(
    false,
    (title) => title,
    () => {},
);
