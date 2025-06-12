<script setup lang="ts">
    import identities from '@/routes/identities';
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
</script>

<template>
    <div class="bg-base-300 flex h-screen w-screen items-center justify-center">
        <Head title="Registration"></Head>
        <div class="card card-border bg-base-100 m-6 w-96 drop-shadow-xl">
            <div class="card-body flex items-center">
                <h1 class="card-title text-3xl">Registration</h1>
                <label class="input mt-6 w-full">
                    <span>Name</span>
                    <input type="text" class="grow text-right placeholder:text-right" placeholder="John Doe" />
                </label>
                <label class="input w-full">
                    <span>Email</span>
                    <input type="email" class="grow text-right placeholder:text-right" placeholder="john.doe@example.com" />
                </label>
                <label class="input w-full" v-show="usePassword">
                    <span>Password</span>
                    <input type="password" class="grow text-right placeholder:text-right" placeholder="************" />
                </label>
                <div class="flex w-full justify-between">
                    <a href="#" class="btn btn-link btn-sm">Already a member?</a>
                    <button class="btn btn-link btn-sm" v-show="usePassword" @click="sendEmail = true">Send magic link instead</button>
                    <button class="btn btn-link btn-sm" v-show="sendEmail" @click="usePassword = true">Use password instead</button>
                </div>
                <div class="w-full">
                    <button class="btn btn-primary btn-block col-start-2">Register</button>
                </div>
                <div class="divider">OR</div>
                <p class="text-sm">Register with your account at:</p>
                <div class="mx-12 mt-4 flex flex-row flex-wrap justify-center gap-2">
                    <a class="btn btn-circle" :href="identities.redirect.url('google')">
                        <GoogleIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('facebook')">
                        <FacebookIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('linkedin-openid')">
                        <LinkedInIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('x')">
                        <XIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('github')">
                        <GitHubIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('slack')">
                        <SlackIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('gitlab')">
                        <GitLabIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('bitbucket')">
                        <BitbucketIcon />
                    </a>
                    <a class="btn btn-circle" :href="identities.redirect.url('twitch')">
                        <TwitchIcon />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
