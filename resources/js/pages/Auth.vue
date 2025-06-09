<script setup lang="ts">
    import federated from '@/routes/federated';
    import BitbucketIcon from '@/user/icons/BitbucketIcon.vue';
    import FacebookIcon from '@/user/icons/FacebookIcon.vue';
    import GitHubIcon from '@/user/icons/GitHubIcon.vue';
    import GitLabIcon from '@/user/icons/GitLabIcon.vue';
    import GoogleIcon from '@/user/icons/GoogleIcon.vue';
    import LinkedInIcon from '@/user/icons/LinkedInIcon.vue';
    import SlackIcon from '@/user/icons/SlackIcon.vue';
    import TwitchIcon from '@/user/icons/TwitchIcon.vue';
    import XIcon from '@/user/icons/XIcon.vue';
    import { Head } from '@inertiajs/vue3';
    import { whenever } from '@vueuse/core';
    import { ref } from 'vue';

    const usePassword = ref(true);
    const sendEmail = ref(false);

    whenever(usePassword, () => (sendEmail.value = false));
    whenever(sendEmail, () => (usePassword.value = false));

    const rememberMe = ref(true);
</script>

<template>
    <div class="bg-base-300 flex h-screen w-screen items-center justify-center">
        <Head title="Welcome"></Head>
        <div class="card card-border bg-base-100 m-6 w-96 drop-shadow-xl">
            <div class="card-body flex items-center">
                <h1 class="card-title text-3xl">Welcome!</h1>
                <label class="input mt-6 w-full">
                    <span>Email</span>
                    <input type="email" class="grow text-right placeholder:text-right" placeholder="your.email@example.com" />
                </label>
                <label class="input w-full" v-show="usePassword">
                    <span>Password</span>
                    <input type="password" class="grow text-right placeholder:text-right" />
                </label>
                <div class="flex w-full justify-between">
                    <label class="label text-xs">
                        <input type="checkbox" v-model="rememberMe" class="checkbox checkbox-xs" />
                        Remember me
                    </label>
                    <button class="btn btn-link btn-sm" v-show="usePassword" @click="sendEmail = true">Send magic link instead</button>
                    <button class="btn btn-link btn-sm" v-show="sendEmail" @click="usePassword = true">Use password instead</button>
                </div>
                <div class="grid w-full grid-cols-2 justify-around gap-2">
                    <button class="btn">Login</button>
                    <button class="btn">Register</button>
                </div>
                <div class="divider">OR</div>
                <a class="btn btn-block" :href="federated.redirect.url('google')"> Use passkey to login </a>
                <div class="divider">OR</div>
                <p class="text-sm">Confirm your identity using:</p>
                <div class="mx-12 mt-4 flex flex-row flex-wrap justify-center gap-2">
                    <a class="btn btn-circle" :href="federated.redirect.url('google')">
                        <GoogleIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('facebook')">
                        <FacebookIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('linkedin-openid')">
                        <LinkedInIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('x')">
                        <XIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('github')">
                        <GitHubIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('slack')">
                        <SlackIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('gitlab')">
                        <GitLabIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('bitbucket')">
                        <BitbucketIcon />
                    </a>
                    <a class="btn btn-circle" :href="federated.redirect.url('twitch')">
                        <TwitchIcon />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
