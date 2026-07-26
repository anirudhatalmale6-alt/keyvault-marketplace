<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import CurrencySwitcher from '@/Components/CurrencySwitcher.vue';
import LocaleSwitcher from '@/Components/LocaleSwitcher.vue';

const page = usePage();
const site = computed(() => page.props.site || { name: 'Marketplace' });
const user = computed(() => page.props.auth?.user);
const categories = computed(() => page.props.navCategories || []);
const flash = computed(() => page.props.flash || {});

const mobileOpen = ref(false);
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <!-- Announcement bar -->
        <div class="bg-brand-600 py-1.5 text-center text-xs font-medium text-white">
            Instant delivery · Secure payments · 24/7 support
        </div>

        <!-- Header -->
        <header class="sticky top-0 z-40 border-b border-gray-200 bg-white/80 backdrop-blur dark:border-gray-800 dark:bg-gray-900/80">
            <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <!-- Brand -->
                <Link href="/" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 7a2 2 0 0 1 2 2m4-1a6 6 0 0 1-7.7 5.7L10 17H8v2H6v2H2v-4l6.3-6.3A6 6 0 1 1 21 8z" />
                        </svg>
                    </span>
                    <span class="text-lg font-semibold tracking-tight">{{ site.name }}</span>
                </Link>

                <!-- Search (desktop) -->
                <div class="ml-2 hidden flex-1 md:block">
                    <div class="relative max-w-lg">
                        <input
                            type="search"
                            placeholder="Search game keys, gift cards…"
                            class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 pl-10 pr-3 text-sm focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800"
                        />
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" />
                        </svg>
                    </div>
                </div>

                <!-- Right controls -->
                <div class="ml-auto flex items-center gap-2">
                    <div class="hidden sm:block"><LocaleSwitcher /></div>
                    <div class="hidden sm:block"><CurrencySwitcher /></div>
                    <ThemeToggle />

                    <template v-if="user">
                        <Link :href="route('dashboard')" class="hidden rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-700 sm:inline-block">
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="hidden rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-brand-600 dark:text-gray-200 sm:inline-block">
                            Sign in
                        </Link>
                        <Link :href="route('register')" class="hidden rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-700 sm:inline-block">
                            Create account
                        </Link>
                    </template>

                    <!-- Mobile menu button -->
                    <button @click="mobileOpen = !mobileOpen" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 sm:hidden dark:border-gray-700 dark:text-gray-300" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </button>
                </div>
            </div>

            <!-- Category nav (desktop) -->
            <nav class="hidden border-t border-gray-100 dark:border-gray-800 md:block">
                <div class="mx-auto flex max-w-7xl items-center gap-6 px-4 py-2 text-sm sm:px-6 lg:px-8">
                    <Link href="/" class="font-medium text-gray-500 hover:text-brand-600 dark:text-gray-400">All products</Link>
                    <span v-for="c in categories" :key="c.id" class="cursor-pointer font-medium text-gray-500 hover:text-brand-600 dark:text-gray-400">
                        {{ c.name }}
                    </span>
                </div>
            </nav>

            <!-- Mobile drawer -->
            <div v-if="mobileOpen" class="border-t border-gray-100 px-4 py-3 sm:hidden dark:border-gray-800">
                <div class="mb-3 flex gap-2">
                    <LocaleSwitcher /><CurrencySwitcher />
                </div>
                <div class="flex flex-col gap-1">
                    <Link v-if="user" :href="route('dashboard')" class="rounded-lg bg-brand-600 px-4 py-2 text-center text-sm font-medium text-white">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Sign in</Link>
                        <Link :href="route('register')" class="rounded-lg bg-brand-600 px-4 py-2 text-center text-sm font-medium text-white">Create account</Link>
                    </template>
                    <hr class="my-2 border-gray-100 dark:border-gray-800" />
                    <span v-for="c in categories" :key="c.id" class="px-1 py-1.5 text-sm text-gray-600 dark:text-gray-300">{{ c.name }}</span>
                </div>
            </div>
        </header>

        <!-- Flash messages -->
        <div v-if="flash.success || flash.error" class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            <div v-if="flash.success" class="rounded-lg bg-green-50 px-4 py-2 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">{{ flash.success }}</div>
            <div v-if="flash.error" class="rounded-lg bg-red-50 px-4 py-2 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-300">{{ flash.error }}</div>
        </div>

        <!-- Page content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 7a2 2 0 0 1 2 2m4-1a6 6 0 0 1-7.7 5.7L10 17H8v2H6v2H2v-4l6.3-6.3A6 6 0 1 1 21 8z"/></svg>
                        </span>
                        <span class="font-semibold">{{ site.name }}</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ site.tagline }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold">Shop</h4>
                    <ul class="mt-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li v-for="c in categories" :key="c.id">{{ c.name }}</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold">Support</h4>
                    <ul class="mt-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li>Help center</li><li>Order status</li><li>Contact us</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold">We accept</h4>
                    <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="rounded border border-gray-200 px-2 py-1 dark:border-gray-700">Visa</span>
                        <span class="rounded border border-gray-200 px-2 py-1 dark:border-gray-700">Stripe</span>
                        <span class="rounded border border-gray-200 px-2 py-1 dark:border-gray-700">PayPal</span>
                        <span class="rounded border border-gray-200 px-2 py-1 dark:border-gray-700">BTC</span>
                        <span class="rounded border border-gray-200 px-2 py-1 dark:border-gray-700">USDT</span>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-100 py-4 text-center text-xs text-gray-400 dark:border-gray-800">
                © {{ new Date().getFullYear() }} {{ site.name }}. All rights reserved.
            </div>
        </footer>
    </div>
</template>
