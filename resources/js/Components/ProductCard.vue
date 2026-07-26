<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useCurrency } from '@/composables/useCurrency';

const props = defineProps({
    product: { type: Object, required: true },
});

const { format } = useCurrency();

const gradient = computed(() => {
    const g = props.product?.meta?.gradient;
    if (Array.isArray(g) && g.length === 2) {
        return `linear-gradient(135deg, ${g[0]}, ${g[1]})`;
    }
    return 'linear-gradient(135deg, #4f46e5, #0ea5e9)';
});

const platform = computed(() => props.product?.meta?.platform || 'Global');

const discount = computed(() => {
    const base = Number(props.product?.base_price || 0);
    const cost = Number(props.product?.cost_price || 0);
    if (base > 0 && cost > 0 && cost < base) {
        const was = base * 1.25;
        return Math.round(((was - base) / was) * 100);
    }
    return 0;
});

const initials = computed(() =>
    (props.product?.name || '')
        .split(' ')
        .slice(0, 3)
        .map((w) => w[0])
        .join('')
        .toUpperCase()
);
</script>

<template>
    <div class="group flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-xl dark:bg-navy-800 dark:ring-navy-700">
        <!-- Box art -->
        <Link :href="route('product.show', product.slug)" class="relative block aspect-[3/4] overflow-hidden rounded-t-xl" :style="{ background: gradient }">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 30% 20%, white 1.5px, transparent 1.5px); background-size: 22px 22px;"></div>

            <div class="flex h-full w-full flex-col items-center justify-center px-3 text-center">
                <span class="text-3xl font-black tracking-tight text-white/90 drop-shadow">{{ initials }}</span>
                <span class="mt-2 line-clamp-3 text-sm font-bold leading-tight text-white drop-shadow">{{ product.name }}</span>
            </div>

            <!-- platform chip bottom-left -->
            <span class="absolute bottom-2 left-2 rounded bg-black/40 px-2 py-0.5 text-[10px] font-semibold text-white backdrop-blur">{{ platform }}</span>
            <!-- discount badge bottom-right -->
            <span v-if="discount" class="absolute bottom-2 right-2 rounded bg-red-600 px-2 py-0.5 text-[11px] font-bold text-white shadow">-{{ discount }}% OFF</span>
        </Link>

        <!-- Details -->
        <div class="flex flex-1 flex-col p-3">
            <Link :href="route('product.show', product.slug)" class="line-clamp-2 min-h-[2.5rem] text-xs font-bold uppercase leading-snug text-gray-800 hover:text-primary dark:text-gray-100">{{ product.name }}</Link>
            <p class="mt-2 text-lg font-extrabold text-gray-900 dark:text-white">{{ format(product.base_price) }}</p>

            <!-- actions -->
            <div class="mt-3 flex gap-2">
                <button class="flex-1 rounded-lg border border-gray-300 py-2 text-xs font-bold uppercase text-gray-700 transition hover:bg-gray-100 dark:border-navy-600 dark:text-gray-200 dark:hover:bg-navy-700">Add</button>
                <button class="flex-1 rounded-lg bg-buy py-2 text-xs font-bold uppercase text-white transition hover:brightness-110">Buy</button>
            </div>
        </div>
    </div>
</template>
