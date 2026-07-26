<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue';
import ProductRail from '@/Components/ProductRail.vue';

const page = usePage();
const site = computed(() => page.props.site || { name: 'Marketplace' });

const props = defineProps({
    categories: { type: Array, default: () => [] },
    featured: { type: Array, default: () => [] },
    rails: { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({}) },
});

// Promo slides for the hero carousel.
const slides = [
    { title: 'Game Keys, Instantly', sub: 'Steam, Xbox, PlayStation & more — delivered in seconds', from: '#4f46e5', to: '#0ea5e9', tag: 'Official Reseller' },
    { title: 'Gift Cards for Everything', sub: 'Amazon, Netflix, Spotify, Google Play & App Store', from: '#db2777', to: '#f97316', tag: 'Best Prices' },
    { title: 'Mobile Top-Ups', sub: 'PUBG UC, Free Fire Diamonds, Valorant Points', from: '#059669', to: '#14b8a6', tag: 'Instant Delivery' },
];
const current = ref(0);
let timer = null;
const go = (i) => { current.value = (i + slides.length) % slides.length; };
onMounted(() => { timer = setInterval(() => go(current.value + 1), 5000); });
onUnmounted(() => timer && clearInterval(timer));

const gradientOf = (p) => {
    const g = p?.meta?.gradient;
    return Array.isArray(g) ? `linear-gradient(135deg, ${g[0]}, ${g[1]})` : 'linear-gradient(135deg,#4f46e5,#0ea5e9)';
};

const firstWord = (t) => (t || '').split(' ')[0];
const restWords = (t) => (t || '').split(' ').slice(1).join(' ');
</script>

<template>
    <Head :title="`${site.name} — Buy game keys, gift cards & top-ups`" />

    <StorefrontLayout>
        <!-- Hero: carousel + featured sidebar -->
        <section class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
            <div class="grid gap-4 lg:grid-cols-[1fr_320px]">
                <!-- Carousel -->
                <div class="relative overflow-hidden rounded-2xl">
                    <div
                        v-for="(s, i) in slides"
                        :key="i"
                        class="relative flex h-64 flex-col justify-center p-8 transition-opacity duration-700 sm:h-80"
                        :class="i === current ? 'opacity-100' : 'pointer-events-none absolute inset-0 opacity-0'"
                        :style="{ background: `linear-gradient(135deg, ${s.from}, ${s.to})` }"
                    >
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 15% 25%, white 1.5px, transparent 1.5px); background-size: 26px 26px;"></div>
                        <span class="relative inline-flex w-fit rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/30">{{ s.tag }}</span>
                        <h1 class="relative mt-3 max-w-md text-3xl font-black leading-tight text-white sm:text-4xl">{{ s.title }}</h1>
                        <p class="relative mt-2 max-w-md text-sm text-white/90 sm:text-base">{{ s.sub }}</p>
                        <Link href="/" class="relative mt-5 w-fit rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 transition hover:bg-white/90">Shop now</Link>
                    </div>
                    <!-- dots -->
                    <div class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                        <button v-for="(s, i) in slides" :key="i" @click="go(i)" :aria-label="`Slide ${i+1}`"
                            class="h-2 rounded-full transition-all" :class="i === current ? 'w-6 bg-white' : 'w-2 bg-white/50'"></button>
                    </div>
                </div>

                <!-- Featured sidebar -->
                <div class="hidden rounded-2xl border border-gray-200 bg-white p-3 lg:block dark:border-gray-800 dark:bg-gray-900">
                    <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Featured</p>
                    <ul class="space-y-1">
                        <li v-for="p in featured.slice(0, 7)" :key="p.id" class="flex cursor-pointer items-center gap-3 rounded-lg px-2 py-1.5 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span class="h-9 w-9 shrink-0 rounded-md" :style="{ background: gradientOf(p) }"></span>
                            <span class="line-clamp-1 text-sm font-medium">{{ p.name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Category chips -->
        <section class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-2">
                <span v-for="c in categories" :key="c.id"
                    class="cursor-pointer rounded-full border border-gray-200 bg-white px-4 py-1.5 text-sm font-medium text-gray-700 transition hover:border-brand-400 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    {{ c.name }}
                </span>
            </div>
        </section>

        <!-- Trust strip -->
        <section class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-3 rounded-2xl border border-gray-200 bg-white p-4 text-center sm:grid-cols-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col items-center"><span class="text-lg font-bold text-brand-600 dark:text-brand-400">Instant</span><span class="text-xs text-gray-500">Auto delivery</span></div>
                <div class="flex flex-col items-center"><span class="text-lg font-bold text-brand-600 dark:text-brand-400">Secure</span><span class="text-xs text-gray-500">Encrypted checkout</span></div>
                <div class="flex flex-col items-center"><span class="text-lg font-bold text-brand-600 dark:text-brand-400">{{ stats.products || 0 }}+</span><span class="text-xs text-gray-500">Products</span></div>
                <div class="flex flex-col items-center"><span class="text-lg font-bold text-brand-600 dark:text-brand-400">24/7</span><span class="text-xs text-gray-500">Support</span></div>
            </div>
        </section>

        <!-- Featured rail -->
        <ProductRail v-if="featured.length" title="Products" highlight="Featured" :products="featured" />

        <!-- Category rails -->
        <ProductRail
            v-for="rail in rails"
            :key="rail.slug"
            :title="restWords(rail.title)"
            :highlight="firstWord(rail.title)"
            :products="rail.products"
        />

        <!-- CTA -->
        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-700 px-8 py-12 text-center">
                <h2 class="text-2xl font-bold text-white sm:text-3xl">Create your free account</h2>
                <p class="mx-auto mt-2 max-w-xl text-brand-100">Wallet, order history, wishlist and instant delivery — all in one place.</p>
                <Link :href="route('register')" class="mt-6 inline-block rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">Get started</Link>
            </div>
        </section>
    </StorefrontLayout>
</template>
