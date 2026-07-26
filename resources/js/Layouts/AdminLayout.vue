<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const site = computed(() => page.props.site || { name: 'Admin' });

const nav = [
    { label: 'Dashboard', route: 'admin.dashboard', match: 'admin.dashboard' },
    { label: 'Appearance', route: 'admin.appearance.edit', match: 'admin.appearance.*' },
];

// Future admin areas (shown disabled to convey the roadmap).
const soon = ['Products', 'Categories', 'Orders', 'Suppliers', 'Users', 'Coupons', 'Currencies', 'Reports', 'Settings'];

const sidebarOpen = ref(false);
const isActive = (m) => route().current(m);
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-navy-900">
        <div class="flex">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 transform bg-navy-950 text-gray-300 transition-transform lg:translate-x-0">
                <div class="flex h-16 items-center gap-2 border-b border-white/5 px-5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 7a2 2 0 0 1 2 2m4-1a6 6 0 0 1-7.7 5.7L10 17H8v2H6v2H2v-4l6.3-6.3A6 6 0 1 1 21 8z"/></svg>
                    </span>
                    <span class="font-extrabold uppercase text-white">{{ site.name }}</span>
                    <span class="rounded bg-white/10 px-1.5 py-0.5 text-[10px] font-bold uppercase">Admin</span>
                </div>
                <nav class="p-3">
                    <Link v-for="item in nav" :key="item.route" :href="route(item.route)"
                        class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition"
                        :class="isActive(item.match) ? 'bg-primary text-white' : 'hover:bg-white/5 hover:text-white'">
                        {{ item.label }}
                    </Link>
                    <p class="mt-5 px-3 text-[10px] font-bold uppercase tracking-wide text-gray-600">Coming soon</p>
                    <span v-for="s in soon" :key="s" class="mb-1 flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-600">
                        {{ s }}
                    </span>
                </nav>
            </aside>

            <!-- Main -->
            <div class="min-h-screen flex-1 lg:ml-64">
                <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 dark:border-navy-800 dark:bg-navy-850 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden" aria-label="Toggle sidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                        </button>
                        <slot name="title"><h1 class="text-lg font-bold">Admin</h1></slot>
                    </div>
                    <div class="flex items-center gap-3">
                        <ThemeToggle />
                        <a href="/" target="_blank" class="hidden text-sm font-medium text-gray-500 hover:text-primary sm:inline">View store ↗</a>
                        <span class="text-sm font-medium">{{ user?.name }}</span>
                        <Link :href="route('logout')" method="post" as="button" class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium hover:bg-gray-200 dark:bg-navy-800 dark:hover:bg-navy-700">Logout</Link>
                    </div>
                </header>

                <main class="p-4 sm:p-6 lg:p-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
