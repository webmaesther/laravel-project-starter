<script setup lang="ts">
    import identities from '@/routes/identities';
    import * as login from '@/routes/login';
    import * as link from '@/routes/login/link';
    import BitbucketIcon from '@/user/icons/BitbucketIcon.vue';
    import FacebookIcon from '@/user/icons/FacebookIcon.vue';
    import GitHubIcon from '@/user/icons/GitHubIcon.vue';
    import GitLabIcon from '@/user/icons/GitLabIcon.vue';
    import GoogleIcon from '@/user/icons/GoogleIcon.vue';
    import LinkedInIcon from '@/user/icons/LinkedInIcon.vue';
    import SlackIcon from '@/user/icons/SlackIcon.vue';
    import TwitchIcon from '@/user/icons/TwitchIcon.vue';
    import XIcon from '@/user/icons/XIcon.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import { ref, watch } from 'vue';

    const form = useForm<{
        email: string;
        password: string;
        remember: boolean;
        action: 'link' | 'password' | null;
    }>({
        email: '',
        password: '',
        remember: true,
        action: null,
    });

    const checkPassword = () => {
        form.submit(login.store());
    };

    const sendMagicLink = () => {
        form.submit(link.store());
    };

    const usePassword = ref(false);

    const submit = () => {
        switch (form.action) {
            case 'link':
                sendMagicLink();
                break;
            case 'password':
                checkPassword();
                break;
            default:
        }
    };

    watch(usePassword, () => {
        form.reset();
        form.clearErrors();
    });
</script>

<template>
    <div class="bg-base-300 flex h-screen w-screen items-center justify-center">
        <Head title="Log in"></Head>
        <div class="card card-border bg-base-100 m-6 w-96 drop-shadow-xl">
            <form class="card-body flex items-center" @submit.prevent="submit">
                <h1 class="card-title text-3xl">Login</h1>
                <label
                    class="input mt-6 w-full"
                    :class="{ 'input-error tooltip tooltip-open tooltip-right tooltip-error': form.errors.email }"
                    :data-tip="form.errors.email"
                >
                    <span>Email</span>
                    <input v-model="form.email" type="text" class="grow text-right placeholder:text-right" placeholder="john.doe@example.com" />
                </label>
                <label
                    class="input w-full"
                    v-if="usePassword"
                    :class="{ 'input-error tooltip tooltip-open tooltip-right tooltip-error': form.errors.password }"
                    :data-tip="form.errors.password"
                >
                    <span>Password</span>
                    <input v-model="form.password" type="password" class="grow text-right placeholder:text-right" placeholder="************" />
                </label>
                <div class="flex w-full justify-between">
                    <label class="label text-xs">
                        <input type="checkbox" v-model="form.remember" class="checkbox checkbox-xs" />
                        Remember me
                    </label>
                    <button class="btn btn-link btn-sm" v-if="usePassword" @click="usePassword = false">Show passwordless options</button>
                    <button class="btn btn-link btn-sm" v-else @click="usePassword = true">Use traditional password</button>
                </div>
                <div class="grid w-full grid-cols-2 gap-2">
                    <button
                        type="submit"
                        @click="form.action = 'password'"
                        value="link"
                        class="btn btn-primary btn-block col-span-2"
                        v-if="usePassword"
                    >
                        Check password
                    </button>
                    <template v-else>
                        <button type="submit" @click="form.action = 'link'" value="link" class="btn btn-secondary btn-block">Send magic link</button>
                        <button class="btn btn-primary btn-block">Use passkey</button>
                    </template>
                </div>
                <div class="mx-12 mt-4 flex flex-row flex-wrap justify-center gap-2">
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('google')">
                        <GoogleIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('facebook')">
                        <FacebookIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('linkedin-openid')">
                        <LinkedInIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('x')">
                        <XIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('github')">
                        <GitHubIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('slack')">
                        <SlackIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('gitlab')">
                        <GitLabIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('bitbucket')">
                        <BitbucketIcon />
                    </a>
                    <a class="btn btn-neutral btn-circle" :href="identities.redirect.url('twitch')">
                        <TwitchIcon />
                    </a>
                </div>
                <a href="#" class="btn btn-link">Not a member yet?</a>
            </form>
        </div>
    </div>
</template>
