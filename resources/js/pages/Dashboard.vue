<script setup lang="ts">
    import { dashboard, logout } from '@/routes';
    import BrandIcon from '@/user/icons/BrandIcon.vue';
    import DashboardIcon from '@/user/icons/DashboardIcon.vue';
    import SidebarIcon from '@/user/icons/SidebarIcon.vue';
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const scrollBarOpen = ref(true);
</script>

<template>
    <div class="drawer lg:drawer-open bg-base-200 text-base-content h-screen">
        <input type="checkbox" class="drawer-toggle" v-model="scrollBarOpen" />
        <div class="drawer-content flex flex-col items-center justify-center p-2">
            <main class="rounded-box bg-base-100 border-base-300 flex min-h-full w-full flex-col drop-shadow-sm">
                <header class="border-base-300 flex h-16 items-center gap-2 border-b px-4 text-sm font-light">
                    <button class="btn btn-ghost btn-square btn-sm" @click="scrollBarOpen = !scrollBarOpen">
                        <SidebarIcon height="16" />
                    </button>
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li><Link :href="dashboard()">Dashboard</Link></li>
                            <li>Settings</li>
                            <li>Profile</li>
                        </ul>
                    </div>
                </header>
                <div class="grid flex-1 grid-cols-1 gap-4 p-4 lg:grid-cols-3">
                    <div class="card card-border border-base-300"></div>
                    <div class="card card-border border-base-300"></div>
                    <div class="card card-border border-base-300"></div>
                    <div class="card card-border border-base-300 lg:col-span-3 lg:row-span-2"></div>
                </div>
            </main>
        </div>
        <div class="drawer-side">
            <div class="drawer-overlay" @click="scrollBarOpen = !scrollBarOpen"></div>
            <div class="bg-base-200 flex min-h-full w-72 flex-col justify-between p-4">
                <div>
                    <Link :href="dashboard()" class="btn btn-ghost mx-2 flex h-full items-center justify-start gap-3 p-2">
                        <div class="btn btn-square btn-sm btn-neutral">
                            <BrandIcon class="h-5" />
                        </div>
                        <h1 class="flex-1 text-left text-sm leading-tight font-medium">Laravel Project Starter</h1>
                    </Link>
                    <ul class="menu menu-vertical p-x-0 w-full">
                        <li class="menu-title text-xs font-normal">Platform</li>
                        <li>
                            <Link :href="dashboard()" class="menu-active"><DashboardIcon height="16" />Dashboard</Link>
                        </li>
                        <li><Link href="#">Settings</Link></li>
                    </ul>
                </div>
                <div class="w-full">
                    <ul class="menu menu-vertical p-x-0 w-full">
                        <li>
                            <a href="https://github.com/webmaesther/laravel-project-starter" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 512 512">
                                    <path
                                        fill="currentColor"
                                        opacity="0.5"
                                        d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"
                                    />
                                </svg>
                                Repository
                            </a>
                        </li>
                        <li>
                            <a href="https://laravel.com/docs/12.x" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 576 512">
                                    <path
                                        fill="currentColor"
                                        opacity="0.5"
                                        d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z"
                                    />
                                </svg>
                                Documentation
                            </a>
                        </li>
                    </ul>
                    <div class="dropdown dropdown-top dropdown-end w-full">
                        <button tabindex="0" class="btn btn-ghost btn-block btn-lg inline-flex">
                            <span class="flex-1 text-left text-sm leading-tight font-normal">{{ $page.props.auth.user.name }}</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 0 320 512">
                                    <path
                                        fill="currentColor"
                                        d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8l256 0c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"
                                    />
                                </svg>
                            </span>
                        </button>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                            <li>
                                <Link href="#" class="flex gap-2">
                                    <div class="avatar avatar-placeholder">
                                        <div class="bg-base-300 text-base-content h-6 rounded-full">
                                            <span class="text-xs">EC</span>
                                        </div>
                                    </div>
                                    {{ $page.props.auth.user.name }}
                                </Link>
                            </li>
                            <li>
                                <Link href="#" class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6" viewBox="0 0 512 512">
                                        <path
                                            fill="currentColor"
                                            opacity="0.5"
                                            d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"
                                        />
                                    </svg>
                                    Settings</Link
                                >
                            </li>
                            <li>
                                <Link :href="logout()" class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6" viewBox="0 0 512 512">
                                        <path
                                            fill="currentColor"
                                            opacity="0.5"
                                            d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"
                                        />
                                    </svg>
                                    Log out
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
