import type { route as routeFn } from 'ziggy-js';

declare global {
    // noinspection ES6ConvertVarToLetConst
    var route: routeFn; // eslint-disable-line no-var
}
