<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue';
import ProductGrid from '@/Components/ProductGrid.vue';
import { useCurrency } from '@/composables/useCurrency';

const props = defineProps({
    product: { type: Object, required: true },
    related: { type: Array, default: () => [] },
});

const { format } = useCurrency();

const gradient = computed(() => {
    const g = props.product?.meta?.gradient;
    return Array.isArray(g) ? `linear-gradient(135deg, ${g[0]}, ${g[1]})` : 'linear-gradient(135deg,#4f46e5,#0ea5e9)';
});
const platform = computed(() => props.product?.meta?.platform || 'Global');

const typeLabel = {
    game_key: 'Game Key', gift_card: 'Gift Card',
    subscription: 'Subscription', prepaid: 'Prepaid Card', software: 'Software',
};

const regions = ['Global', 'US', 'EU', 'UK'];
const denominations = computed(() => {
    // Illustrative variant options for the Loaded-style selectors.
    return props.product.type === 'gift_card' || props.product.type === 'prepaid'
        ? ['10 USD', '25 USD', '50 USD', '100 USD']
        : ['Standard Edition', 'Deluxe Edition'];
});
</script>

<template>
    <Head :title="product.name" />

    <StorefrontLayout>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <Link href="/" class="hover:text-primary">Home</Link>
                <span>/</span>
                <span v-if="product.category" class="hover:text-primary">{{ product.category.name }}</span>
                <span v-if="product.category">/</span>
                <span class="text-gray-700 dark:text-gray-200">{{ product.name }}</span>
            </nav>

            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Image -->
                <div class="relative aspect-[4/5] overflow-hidden rounded-2xl" :style="{ background: gradient }">
                    <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 30% 20%, white 1.5px, transparent 1.5px); background-size: 26px 26px;"></div>
                    <div class="flex h-full flex-col items-center justify-center px-6 text-center">
                        <span class="text-6xl font-black text-white/90 drop-shadow">{{ platform }}</span>
                        <span class="mt-4 text-2xl font-bold text-white drop-shadow">{{ product.name }}</span>
                    </div>
                </div>

                <!-- Details -->
                <div>
                    <h1 class="text-2xl font-extrabold uppercase leading-tight text-gray-900 sm:text-3xl dark:text-white">{{ product.name }}</h1>

                    <!-- Selectors -->
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase text-gray-500">Region</label>
                            <select class="w-full rounded-lg border-gray-300 bg-white text-sm dark:border-navy-600 dark:bg-navy-800 dark:text-gray-100">
                                <option v-for="r in regions" :key="r">{{ r }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase text-gray-500">Edition / Value</label>
                            <select class="w-full rounded-lg border-gray-300 bg-white text-sm dark:border-navy-600 dark:bg-navy-800 dark:text-gray-100">
                                <option v-for="d in denominations" :key="d">{{ d }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Price -->
                    <p class="mt-6 text-4xl font-extrabold text-gray-900 dark:text-white">{{ format(product.base_price) }}</p>

                    <!-- Actions -->
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <button class="rounded-lg border border-gray-300 py-3 text-sm font-bold uppercase text-gray-700 transition hover:bg-gray-100 dark:border-navy-600 dark:text-gray-100 dark:hover:bg-navy-800">Add to cart</button>
                        <button class="rounded-lg bg-buy py-3 text-sm font-bold uppercase text-white transition hover:brightness-110">Buy now</button>
                    </div>

                    <!-- Stock badges -->
                    <div class="mt-5 flex flex-wrap gap-x-8 gap-y-2 text-sm">
                        <span class="flex items-center gap-2" :class="product.in_stock ? 'text-buy' : 'text-red-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ product.in_stock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                        <span class="flex items-center gap-2 text-buy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            Digital Key Code
                        </span>
                        <span class="flex items-center gap-2 text-buy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            Instant Delivery
                        </span>
                    </div>

                    <!-- Meta table -->
                    <dl class="mt-8 grid grid-cols-2 gap-x-8 gap-y-3 border-t border-gray-200 pt-6 text-sm dark:border-navy-700">
                        <div class="flex justify-between"><dt class="text-gray-500">Type</dt><dd class="font-semibold">{{ typeLabel[product.type] || product.type }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Region</dt><dd class="font-semibold">{{ platform }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Delivery</dt><dd class="font-semibold">Instant</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Category</dt><dd class="font-semibold">{{ product.category?.name || '—' }}</dd></div>
                    </dl>

                    <p v-if="product.description" class="mt-6 text-sm leading-relaxed text-gray-600 dark:text-gray-300">{{ product.description }}</p>
                </div>
            </div>
        </div>

        <!-- Related -->
        <ProductGrid v-if="related.length" title="You may also like" :products="related" :limit="5" />
    </StorefrontLayout>
</template>
