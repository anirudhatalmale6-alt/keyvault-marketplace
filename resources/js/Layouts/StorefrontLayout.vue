<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import CurrencySwitcher from '@/Components/CurrencySwitcher.vue';
import LocaleSwitcher from '@/Components/LocaleSwitcher.vue';

const page = usePage();
const site = computed(() => page.props.site || { name: 'Marketplace' });
const theme = computed(() => page.props.theme || {});
const logoText = computed(() => theme.value.logo_text || site.value.name);
const tagline = computed(() => theme.value.tagline || 'Pay Less. Game More.');
const user = computed(() => page.props.auth?.user);
const categories = computed(() => page.props.navCategories || []);
const flash = computed(() => page.props.flash || {});

const footerAbout = computed(() => theme.value.footer_about
    || `${logoText.value} is your digital game store — get more gaming for your money with savings on games, memberships, top-ups and digital keys across thousands of products. Instant delivery, secure checkout, 24/7 support.`);

const mobileOpen = ref(false);
const year = new Date().getFullYear();

const socials = ['X', 'Facebook', 'Instagram', 'TikTok', 'YouTube', 'Twitch', 'Discord'];
const payments = ['PayPal', 'Visa', 'Mastercard', 'Apple Pay', 'iDEAL', 'Bancontact', 'BTC', 'USDT'];
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-50 text-gray-900 dark:bg-navy-900 dark:text-gray-100">
        <!-- Optional announcement bar -->
        <div v-if="theme.announcement_enabled && theme.announcement_text" class="bg-buy py-1.5 text-center text-xs font-semibold text-white">
            {{ theme.announcement_text }}
        </div>

        <!-- Tier 1: utility strip -->
        <div class="bg-navy-950 text-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-2 text-xs sm:px-6 lg:px-8">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-aqua-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span class="font-medium text-gray-200">{{ theme.utility_left }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="hidden text-right font-medium text-gray-200 sm:inline">{{ theme.utility_right }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-aqua-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/><path d="m13 11-2 3h3l-2 3"/></svg>
                </div>
            </div>
        </div>

        <!-- Tier 2 + 3: brand header (always navy = brand chrome) -->
        <header class="sticky top-0 z-40 bg-navy-700 text-white shadow-lg">
            <!-- Main bar -->
            <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <Link href="/" class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 7a2 2 0 0 1 2 2m4-1a6 6 0 0 1-7.7 5.7L10 17H8v2H6v2H2v-4l6.3-6.3A6 6 0 1 1 21 8z"/></svg>
                    </span>
                    <span class="text-xl font-extrabold uppercase tracking-tight">{{ logoText }}<span class="text-primary">.</span></span>
                    <span class="hidden text-xs font-semibold uppercase tracking-widest text-gray-300 lg:inline">{{ tagline }}</span>
                </Link>

                <!-- Search -->
                <div class="mx-2 hidden flex-1 md:block">
                    <div class="relative mx-auto max-w-xl">
                        <input type="search" placeholder="Search by title…"
                            class="w-full rounded-full border-0 bg-white py-2.5 pl-11 pr-4 text-sm text-gray-800 focus:ring-2 focus:ring-brand-400" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-3 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                </div>

                <!-- Right controls -->
                <div class="ml-auto flex items-center gap-3">
                    <div class="hidden items-center gap-2 lg:flex">
                        <LocaleSwitcher />
                        <CurrencySwitcher />
                    </div>
                    <ThemeToggle />
                    <button aria-label="Wishlist" class="hidden h-9 w-9 items-center justify-center rounded-full text-gray-200 transition hover:bg-white/10 sm:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                    </button>
                    <component :is="user ? 'a' : 'a'" :href="user ? route('dashboard') : route('login')" aria-label="Account" class="flex h-9 w-9 items-center justify-center rounded-full text-gray-200 transition hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </component>
                    <button aria-label="Cart" class="relative flex h-9 w-9 items-center justify-center rounded-full text-gray-200 transition hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </button>
                    <button @click="mobileOpen = !mobileOpen" class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-200 md:hidden" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </button>
                </div>
            </div>

            <!-- Nav bar -->
            <nav class="hidden border-t border-white/10 md:block">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 text-sm font-semibold uppercase tracking-wide sm:px-6 lg:px-8">
                    <div class="flex items-center gap-6">
                        <Link href="/" class="text-gray-200 transition hover:text-white">All</Link>
                        <span v-for="c in categories" :key="c.id" class="flex cursor-pointer items-center gap-1 text-gray-200 transition hover:text-white">
                            {{ c.name }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </span>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="cursor-pointer text-gray-200 transition hover:text-white">Deals</span>
                        <span class="cursor-pointer text-gray-200 transition hover:text-white">Latest</span>
                        <span class="cursor-pointer text-gray-200 transition hover:text-white">Pre-order</span>
                    </div>
                </div>
            </nav>

            <!-- Mobile search + drawer -->
            <div class="px-4 pb-3 md:hidden">
                <div class="relative">
                    <input type="search" placeholder="Search by title…" class="w-full rounded-full border-0 bg-white py-2.5 pl-11 pr-4 text-sm text-gray-800" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-3 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>
            <div v-if="mobileOpen" class="border-t border-white/10 px-4 py-3 md:hidden">
                <div class="mb-3 flex gap-2"><LocaleSwitcher /><CurrencySwitcher /></div>
                <div class="flex flex-col gap-1 text-sm font-semibold uppercase">
                    <Link v-if="user" :href="route('dashboard')" class="rounded-lg bg-primary px-4 py-2 text-center">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="px-1 py-2 text-gray-200">Sign in</Link>
                        <Link :href="route('register')" class="rounded-lg bg-primary px-4 py-2 text-center">Create account</Link>
                    </template>
                    <hr class="my-2 border-white/10" />
                    <span v-for="c in categories" :key="c.id" class="px-1 py-1.5 text-gray-200">{{ c.name }}</span>
                </div>
            </div>
        </header>

        <!-- Flash -->
        <div v-if="flash.success || flash.error" class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            <div v-if="flash.success" class="rounded-lg bg-grass-500/15 px-4 py-2 text-sm text-grass-600 dark:text-grass-400">{{ flash.success }}</div>
            <div v-if="flash.error" class="rounded-lg bg-red-500/15 px-4 py-2 text-sm text-red-500">{{ flash.error }}</div>
        </div>

        <!-- Page -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="mt-10 bg-navy-950 text-gray-300">
            <!-- Followers bar -->
            <div class="border-b border-white/5 bg-navy-800">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-6 sm:flex-row sm:px-6 lg:px-8">
                    <h3 class="flex items-center gap-3 text-2xl font-extrabold text-white">
                        <span class="h-7 w-1.5 rounded-full bg-buy"></span>
                        Over <span class="text-primary">1 Million</span> Gamers
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="s in socials" :key="s" :title="s" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white transition hover:bg-primary">{{ s[0] }}</span>
                    </div>
                </div>
            </div>

            <!-- Columns -->
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
                <div>
                    <div class="flex items-center gap-2 text-lg font-extrabold uppercase text-white">
                        {{ logoText }}<span class="text-primary">.</span>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-gray-400">{{ footerAbout }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-white">{{ logoText }}</h4>
                    <ul class="mt-4 space-y-2 text-sm text-gray-400">
                        <li class="cursor-pointer hover:text-white">About Us</li>
                        <li class="cursor-pointer hover:text-white">Blog</li>
                        <li class="cursor-pointer hover:text-white">FAQ</li>
                        <li class="cursor-pointer hover:text-white">Privacy Policy</li>
                        <li class="cursor-pointer hover:text-white">Terms &amp; Conditions</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white">My Account</h4>
                    <ul class="mt-4 space-y-2 text-sm text-gray-400">
                        <li class="cursor-pointer hover:text-white">My Account</li>
                        <li class="cursor-pointer hover:text-white">My Orders</li>
                        <li class="cursor-pointer hover:text-white">Wishlist</li>
                        <li class="cursor-pointer hover:text-white">Affiliate Program</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white">Customer Service</h4>
                    <ul class="mt-4 space-y-2 text-sm text-gray-400">
                        <li class="cursor-pointer hover:text-white">Help Center</li>
                        <li class="cursor-pointer hover:text-white">Support Requests</li>
                    </ul>
                </div>
            </div>

            <!-- Payments -->
            <div class="border-t border-white/5">
                <div class="mx-auto flex max-w-7xl flex-col items-center gap-4 px-4 py-6 sm:flex-row sm:px-6 lg:px-8">
                    <span class="text-xs font-bold uppercase tracking-wide text-grass-400">Accepted Payment Channels</span>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="p in payments" :key="p" class="rounded bg-white/90 px-2 py-1 text-[10px] font-bold text-navy-900">{{ p }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-navy-950 py-4 text-center text-xs text-gray-500">
                © {{ year }} {{ logoText }}. All rights reserved.
            </div>
        </footer>
    </div>
</template>
