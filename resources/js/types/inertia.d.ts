import { AppPageProps } from '@/types';
import { PageProps as InertiaPageProps, Page, Router } from '@inertiajs/core';

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $page: Page<InertiaPageProps>;
        $inertia: Router;
    }
}
