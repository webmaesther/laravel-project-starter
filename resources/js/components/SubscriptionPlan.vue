<script setup lang="ts">
    import CheckMark from '@/components/icons/CheckMark.vue';
    import { usePaddle } from '@/composables/usePaddle';
    import { subscribe } from '@/routes/api';
    import { CheckoutOpenOptions } from '@paddle/paddle-js';
    import axios from 'axios';
    import { ref } from 'vue';

    const { plan } = defineProps<{
        plan: {
            id: string;
            label: string;
            prices: {
                id: string;
                label: string;
            }[];
            features: string[];
            button: string;
        };
    }>();

    const price = ref<string>(plan.prices[0].id);

    const paddle = usePaddle();

    const checkout = async () => {
        const response = await axios.get<CheckoutOpenOptions>(
            subscribe.url({
                subscription: plan.id,
                price: price.value,
            }),
        );
        const options = response.data;

        paddle.checkout(options);
    };
</script>

<template>
    <div class="card card-xl bg-base-100 border-accent shadow-accent hover:drop-shadow-accent w-96 border-2 shadow-sm hover:drop-shadow-xl">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="text-3xl font-bold">{{ plan.label }}</h2>
                <div class="join">
                    <button
                        v-for="p in plan.prices"
                        :key="p.id"
                        class="btn btn-sm join-item"
                        @click="price = p.id"
                        :class="{ 'btn-accent btn-active': p.id === price }"
                    >
                        {{ p.label }}
                    </button>
                </div>
            </div>
            <ul class="mt-6 flex flex-col gap-2 text-xs">
                <li v-for="feature in plan.features" :key="feature">
                    <CheckMark />
                    <span>{{ feature }}</span>
                </li>
            </ul>
            <div class="mt-6">
                <button @click="checkout" class="btn btn-primary btn-block">{{ plan.button }}</button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
