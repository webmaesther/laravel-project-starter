import { RouteParams, ValidRouteName } from 'ziggy-js';

declare global {
    function route<T extends ValidRouteName>(name: T, params?: RouteParams<T> | undefined, absolute?: boolean): string;
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        route: <T extends ValidRouteName>(name: T, params?: RouteParams<T> | undefined, absolute?: boolean) => string;
    }
}
