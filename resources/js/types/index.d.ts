import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface ZiggyConfig extends Config {
    location: string;
}

export interface SharedData extends PageProps {
    name: string;
    auth: Auth;
    ziggy: ZiggyConfig;
}

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}
