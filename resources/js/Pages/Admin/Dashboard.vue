<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
});

const money = (v) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(v || 0);

const cards = [
    { label: 'Products', key: 'products' },
    { label: 'Active', key: 'active' },
    { label: 'Categories', key: 'categories' },
    { label: 'Orders', key: 'orders' },
    { label: 'Customers', key: 'customers' },
];
</script>

<template>
    <Head title="Admin — Dashboard" />
    <AdminLayout>
        <template #title><h1 class="text-lg font-bold">Dashboard</h1></template>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-6">
            <div v-for="c in cards" :key="c.key" class="rounded-xl border border-gray-200 bg-white p-5 dark:border-navy-800 dark:bg-navy-850">
                <p class="text-sm text-gray-500">{{ c.label }}</p>
                <p class="mt-2 text-2xl font-extrabold">{{ stats[c.key] ?? 0 }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-navy-800 dark:bg-navy-850">
                <p class="text-sm text-gray-500">Revenue</p>
                <p class="mt-2 text-2xl font-extrabold text-buy">{{ money(stats.revenue) }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
            <h2 class="text-lg font-bold">Customize your store</h2>
            <p class="mt-1 text-sm text-gray-500">Change colors, fonts, logo, banners, homepage sections and more — no code needed.</p>
            <Link :href="route('admin.appearance.edit')" class="mt-4 inline-block rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:brightness-110">Open Appearance manager</Link>
        </div>
    </AdminLayout>
</template>
