<script setup lang="ts">
    import SubscriptionPlan from '@/components/SubscriptionPlan.vue';

    defineProps<{
        plans: {
            id: string;
            label: string;
            prices: {
                id: string;
                label: string;
            }[];
            features: string[];
            button: string;
        }[];
    }>();
</script>

<template>
    <div class="hero min-h-screen bg-(image:--bg-image-light) dark:bg-(image:--bg-image-dark)">
        <div class="hero-overlay overlay"></div>
        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">Laravel Project Starter</h1>
                <p class="mb-5">The all-in-one Project Starter Kit.</p>
                <button class="btn btn-primary">Ready, set, go!</button>
            </div>
        </div>
    </div>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content text-center">
            <SubscriptionPlan v-for="plan in plans" :key="plan.id" :plan />
        </div>
    </div>
</template>
