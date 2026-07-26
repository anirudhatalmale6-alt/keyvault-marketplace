<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    wallet: { type: Object, default: () => ({ balance: 0, currency: 'USD' }) },
    referral: { type: Object, default: () => ({ code: '', count: 0 }) },
    stats: { type: Object, default: () => ({ orders: 0, completed: 0, wishlist: 0 }) },
    recentOrders: { type: Array, default: () => [] },
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const money = (v, c) => new Intl.NumberFormat('en-US', { style: 'currency', currency: c || 'USD' }).format(v || 0);

const cards = computed(() => [
    { label: 'Wallet balance', value: money(props.wallet.balance, props.wallet.currency) },
    { label: 'Total orders', value: props.stats.orders },
    { label: 'Completed', value: props.stats.completed },
    { label: 'Wishlist', value: props.stats.wishlist },
]);

const copyReferral = () => {
    const url = `${window.location.origin}/register?ref=${props.referral.code}`;
    navigator.clipboard?.writeText(url);
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Welcome back, {{ user.name }}
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <!-- Stat cards -->
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    <div v-for="c in cards" :key="c.label" class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ c.label }}</p>
                        <p class="mt-2 text-2xl font-bold">{{ c.value }}</p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <!-- Recent orders -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 lg:col-span-2 dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold">Recent orders</h3>
                        </div>
                        <div v-if="recentOrders.length" class="mt-4 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="text-left text-gray-400">
                                    <tr>
                                        <th class="pb-2 font-medium">Order</th>
                                        <th class="pb-2 font-medium">Status</th>
                                        <th class="pb-2 text-right font-medium">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <tr v-for="o in recentOrders" :key="o.id">
                                        <td class="py-2 font-medium">{{ o.order_number }}</td>
                                        <td class="py-2"><span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs capitalize dark:bg-gray-800">{{ o.status }}</span></td>
                                        <td class="py-2 text-right">{{ money(o.total, o.currency) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="mt-6 rounded-lg border border-dashed border-gray-200 py-10 text-center text-sm text-gray-400 dark:border-gray-700">
                            No orders yet — your purchases will appear here.
                        </div>
                    </div>

                    <!-- Referral -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="font-semibold">Refer &amp; earn</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Share your code and earn rewards when friends buy.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <code class="flex-1 rounded-lg bg-gray-100 px-3 py-2 text-center font-mono text-sm dark:bg-gray-800">{{ referral.code }}</code>
                            <button @click="copyReferral" class="rounded-lg bg-brand-600 px-3 py-2 text-sm font-medium text-white hover:bg-brand-700">Copy link</button>
                        </div>
                        <p class="mt-3 text-xs text-gray-400">{{ referral.count }} friend(s) referred</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
