<script setup>
import { computed } from 'vue';
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
        // Show an illustrative "was" price above the sell price.
        const was = base * 1.2;
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
    <div class="group w-full cursor-pointer overflow-hidden rounded-xl border border-gray-200 bg-white transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">
        <!-- Artwork -->
        <div class="relative aspect-[3/4] overflow-hidden" :style="{ background: gradient }">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 30% 20%, white 1.5px, transparent 1.5px); background-size: 22px 22px;"></div>

            <span v-if="discount" class="absolute left-2 top-2 z-10 rounded-md bg-amber-400 px-2 py-0.5 text-xs font-bold text-gray-900 shadow">
                -{{ discount }}%
            </span>
            <span class="absolute right-2 top-2 z-10 rounded-md bg-black/30 px-2 py-0.5 text-[10px] font-medium text-white backdrop-blur">
                {{ platform }}
            </span>

            <div class="flex h-full w-full flex-col items-center justify-center px-3 text-center">
                <span class="text-3xl font-black tracking-tight text-white/90 drop-shadow">{{ initials }}</span>
                <span class="mt-2 line-clamp-3 text-sm font-bold leading-tight text-white drop-shadow">{{ product.name }}</span>
            </div>

            <!-- Hover buy overlay -->
            <div class="absolute inset-x-0 bottom-0 translate-y-full bg-black/40 py-2 text-center text-xs font-semibold text-white opacity-0 backdrop-blur transition group-hover:translate-y-0 group-hover:opacity-100">
                View product
            </div>
        </div>

        <!-- Footer -->
        <div class="p-3">
            <p class="line-clamp-1 text-sm font-medium text-gray-800 dark:text-gray-100">{{ product.name }}</p>
            <div class="mt-1 flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-gray-400">from</p>
                    <p class="text-base font-bold text-brand-600 dark:text-brand-400">{{ format(product.base_price) }}</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-white transition group-hover:bg-brand-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </span>
            </div>
        </div>
    </div>
</template>
