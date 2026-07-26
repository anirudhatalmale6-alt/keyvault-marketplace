<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue';
import ProductGrid from '@/Components/ProductGrid.vue';

const page = usePage();
const site = computed(() => page.props.site || { name: 'Marketplace' });

const props = defineProps({
    categories: { type: Array, default: () => [] },
    featured: { type: Array, default: () => [] },
    rails: { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({}) },
});

// Promo slides for the hero carousel (centre slide + side peeks like Loaded).
const slides = [
    { title: 'Summer of Savings', sub: 'Up to 90% off games & DLCs', from: '#4338ca', to: '#6d28d9', cta: 'Shop deals' },
    { title: 'Earn 5% Cashback', sub: 'On all games & DLCs — logged-in users', from: '#1d4ed8', to: '#0ea5e9', cta: 'Shop now' },
    { title: 'Gift Cards, Instantly', sub: 'PSN, Xbox, Steam, Amazon & more', from: '#db2777', to: '#f97316', cta: 'Browse cards' },
    { title: 'Mobile Top-Ups', sub: 'PUBG UC, Free Fire, Valorant Points', from: '#059669', to: '#14b8a6', cta: 'Top up now' },
];
const current = ref(1);
let timer = null;
const go = (i) => { current.value = (i + slides.length) % slides.length; };
onMounted(() => { timer = setInterval(() => go(current.value + 1), 5000); });
onUnmounted(() => timer && clearInterval(timer));

const prevIdx = computed(() => (current.value - 1 + slides.length) % slides.length);
const nextIdx = computed(() => (current.value + 1) % slides.length);
</script>

<template>
    <Head :title="`${site.name} — Buy game keys, gift cards & top-ups`" />

    <StorefrontLayout>
        <!-- Hero carousel: side peeks + centre banner -->
        <section class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
            <div class="flex items-stretch gap-4">
                <!-- left peek -->
                <div class="hidden w-24 shrink-0 overflow-hidden rounded-2xl opacity-60 lg:block xl:w-40" :style="{ background: `linear-gradient(135deg, ${slides[prevIdx].from}, ${slides[prevIdx].to})` }"></div>

                <!-- centre -->
                <div class="relative min-h-[220px] flex-1 overflow-hidden rounded-2xl sm:min-h-[300px]">
                    <div v-for="(s, i) in slides" :key="i"
                        class="absolute inset-0 flex flex-col justify-center p-8 transition-opacity duration-700"
                        :class="i === current ? 'opacity-100' : 'pointer-events-none opacity-0'"
                        :style="{ background: `linear-gradient(135deg, ${s.from}, ${s.to})` }">
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 15% 25%, white 1.5px, transparent 1.5px); background-size: 26px 26px;"></div>
                        <h1 class="relative max-w-md text-3xl font-extrabold leading-tight text-white sm:text-5xl">{{ s.title }}</h1>
                        <p class="relative mt-3 max-w-md text-sm text-white/90 sm:text-lg">{{ s.sub }}</p>
                        <Link href="/" class="relative mt-6 w-fit rounded-full bg-white px-6 py-2.5 text-sm font-bold uppercase text-navy-900 transition hover:bg-white/90">{{ s.cta }}</Link>
                    </div>

                    <!-- arrows -->
                    <button @click="go(current - 1)" aria-label="Previous" class="absolute left-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur transition hover:bg-black/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button @click="go(current + 1)" aria-label="Next" class="absolute right-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur transition hover:bg-black/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                    <div class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                        <button v-for="(s, i) in slides" :key="i" @click="go(i)" :aria-label="`Slide ${i+1}`" class="h-2 rounded-full transition-all" :class="i === current ? 'w-6 bg-white' : 'w-2 bg-white/50'"></button>
                    </div>
                </div>

                <!-- right peek -->
                <div class="hidden w-24 shrink-0 overflow-hidden rounded-2xl opacity-60 lg:block xl:w-40" :style="{ background: `linear-gradient(135deg, ${slides[nextIdx].from}, ${slides[nextIdx].to})` }"></div>
            </div>
        </section>

        <!-- Best Sellers -->
        <ProductGrid v-if="featured.length" title="Best Sellers" :products="featured" :limit="10" />

        <!-- Category sections -->
        <ProductGrid v-for="rail in rails" :key="rail.slug" :title="rail.title" :products="rail.products" :limit="5" />

        <!-- CTA -->
        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-navy-700 to-brand-700 px-8 py-12 text-center">
                <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Create your free account</h2>
                <p class="mx-auto mt-2 max-w-xl text-gray-200">Wallet, order history, wishlist and instant delivery — all in one place.</p>
                <Link :href="route('register')" class="mt-6 inline-block rounded-full bg-grass-500 px-8 py-3 text-sm font-bold uppercase text-white transition hover:bg-grass-600">Get started</Link>
            </div>
        </section>
    </StorefrontLayout>
</template>
