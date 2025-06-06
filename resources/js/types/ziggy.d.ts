import { SharedData } from '@/types/index';
import type { route as routeFn } from 'ziggy-js';

declare global {
    const route: routeFn;
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        route: routeFn;
    }
}

declare module '@inertiajs/core' {
    type PageProps = SharedData;
}
