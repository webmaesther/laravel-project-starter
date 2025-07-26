<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="hero background min-h-screen">
        <div class="hero-overlay overlay"></div>
        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">Laravel Project Starter</h1>
                <p class="mb-5">The all-in-one Starter Kit.</p>
                <Link href="/login" class="btn btn-primary">Login</Link>
            </div>
        </div>
    </div>
</template>
