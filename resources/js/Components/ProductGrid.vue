<script setup>
import ProductCard from '@/Components/ProductCard.vue';

defineProps({
    title: { type: String, required: true },
    products: { type: Array, default: () => [] },
    limit: { type: Number, default: 10 },
});
</script>

<template>
    <section v-if="products.length" class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-5 flex items-end justify-between">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl dark:text-white">{{ title }}</h2>
            <span class="cursor-pointer text-sm font-semibold text-brand-500 hover:underline">View all</span>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            <ProductCard v-for="p in products.slice(0, limit)" :key="p.id" :product="p" />
        </div>
    </section>
</template>
