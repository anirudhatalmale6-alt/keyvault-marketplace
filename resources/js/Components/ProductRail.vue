<script setup>
import { ref } from 'vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    title: { type: String, required: true },
    highlight: { type: String, default: '' }, // first word rendered in amber
    products: { type: Array, default: () => [] },
});

const track = ref(null);

const scrollBy = (dir) => {
    if (track.value) {
        track.value.scrollBy({ left: dir * (track.value.clientWidth * 0.8), behavior: 'smooth' });
    }
};
</script>

<template>
    <section v-if="products.length" class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="h-6 w-1.5 rounded-full bg-amber-400"></span>
                <h2 class="text-xl font-bold tracking-tight">
                    <span class="text-amber-400">{{ highlight }}</span>
                    <span class="text-gray-900 dark:text-white"> {{ title }}</span>
                </h2>
            </div>
            <div class="flex gap-2">
                <button @click="scrollBy(-1)" aria-label="Scroll left" class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button @click="scrollBy(1)" aria-label="Scroll right" class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>

        <div ref="track" class="flex gap-4 overflow-x-auto scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <div v-for="p in products" :key="p.id" class="w-40 shrink-0 sm:w-44">
                <ProductCard :product="p" />
            </div>
        </div>
    </section>
</template>
