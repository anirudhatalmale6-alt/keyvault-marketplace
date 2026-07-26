<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue';

const page = usePage();
const site = computed(() => page.props.site || { name: 'Marketplace' });

const props = defineProps({
    categories: { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({}) },
});

const features = [
    { title: 'Instant delivery', desc: 'Keys land in your account seconds after payment — fully automated.', icon: 'bolt' },
    { title: 'Secure payments', desc: 'Stripe, PayPal & crypto with encrypted checkout and fraud checks.', icon: 'shield' },
    { title: 'Best prices', desc: 'Live supplier pricing across regions, converted to your currency.', icon: 'tag' },
    { title: '24/7 support', desc: 'Ticket system and fast human help whenever you need it.', icon: 'chat' },
];
</script>

<template>
    <Head :title="`${site.name} — Digital marketplace`" />

    <StorefrontLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden border-b border-gray-200 bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900 dark:border-gray-800">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size: 28px 28px;"></div>
            <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-medium text-white ring-1 ring-inset ring-white/25">
                        Digital goods, delivered instantly
                    </span>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                        Game keys, gift cards & subscriptions — at the best prices
                    </h1>
                    <p class="mt-4 text-lg text-brand-100">
                        Buy digital products from trusted suppliers worldwide. Pay your way, get your code in seconds.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <Link href="/" class="rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 shadow-sm transition hover:bg-brand-50">
                            Browse products
                        </Link>
                        <Link :href="route('register')" class="rounded-lg bg-brand-500/30 px-6 py-3 text-sm font-semibold text-white ring-1 ring-inset ring-white/30 transition hover:bg-brand-500/50">
                            Create free account
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Shop by category</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Find exactly what you need</p>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div
                    v-for="c in categories"
                    :key="c.id"
                    class="group cursor-pointer rounded-xl border border-gray-200 bg-white p-6 text-center transition hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-brand-700"
                >
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white dark:bg-brand-950">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg>
                    </div>
                    <h3 class="mt-4 font-semibold">{{ c.name }}</h3>
                    <p class="mt-1 text-xs text-gray-400">Explore →</p>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="border-y border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
                <div v-for="f in features" :key="f.title" class="flex flex-col">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-600/10 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <h3 class="mt-4 font-semibold">{{ f.title }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ f.desc }}</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-700 px-8 py-12 text-center">
                <h2 class="text-2xl font-bold text-white sm:text-3xl">Ready to start selling or buying?</h2>
                <p class="mx-auto mt-2 max-w-xl text-brand-100">Join {{ site.name }} today. Wallet, order history and instant delivery all in one place.</p>
                <Link :href="route('register')" class="mt-6 inline-block rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                    Get started — it's free
                </Link>
            </div>
        </section>
    </StorefrontLayout>
</template>
