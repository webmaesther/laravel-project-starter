<script setup lang="ts">
    import { dashboard } from '@/routes';
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
                <div>
                    <ul class="menu menu-vertical p-x-0 w-full">
                        <li><Link href="">Documentation</Link></li>
                    </ul>
                    <Link href="#" class="btn btn-ghost mx-2 flex h-full items-center justify-start gap-3 p-2">
                        <span class="flex-1 text-left text-sm leading-tight font-normal">{{ $page.props.auth.user.name }}</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
