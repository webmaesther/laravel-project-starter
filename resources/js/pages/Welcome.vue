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
</script>

<template>
    <div class="bg-base-300 flex h-screen w-screen items-center justify-center">
        <Head title="Welcome"></Head>
        <div class="card card-border bg-base-100 m-6 w-96 drop-shadow-xl">
            <div class="card-body flex items-center">
                <h1 class="card-title text-3xl">Welcome!</h1>
                <label class="input mt-6 w-full">
                    <span>Email</span>
                    <input type="text" class="grow" placeholder="your.email@example.com" />
                </label>
                <div class="card-actions"></div>
                <div class="grid w-full grid-cols-2 justify-around gap-2">
                    <button class="btn">Login</button>
                    <button class="btn">Register</button>
                </div>
                <div class="divider">OR</div>
                <p class="text-sm">Confirm your identity with:</p>
                <a class="btn btn-block" :href="federated.redirect.url('google')">
                    <GoogleIcon />
                    Google
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('facebook')">
                    <FacebookIcon />
                    Facebook
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('linkedin-openid')">
                    <LinkedInIcon />
                    LinkedIn
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('x')">
                    <XIcon />
                    X
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('github')">
                    <GitHubIcon />
                    GitHub
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('slack')">
                    <SlackIcon />
                    Slack
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('gitlab')">
                    <GitLabIcon />
                    Gitlab
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('bitbucket')">
                    <BitbucketIcon />
                    Bitbucket
                </a>
                <a class="btn btn-block" :href="federated.redirect.url('twitch')">
                    <TwitchIcon />
                    Twitch
                </a>
            </div>
        </div>
    </div>
</template>
