<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePreferences } from '@/composables/usePreferences';

const page = usePage();
const currencies = computed(() => page.props.currencies || []);
const { currency, setCurrency } = usePreferences();
</script>

<template>
    <div class="relative">
        <select
            :value="currency"
            @change="setCurrency($event.target.value)"
            aria-label="Select currency"
            class="cursor-pointer rounded-lg border-gray-200 bg-white py-1.5 pl-3 pr-8 text-sm text-gray-700 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
        >
            <option v-for="c in currencies" :key="c.code" :value="c.code">
                {{ c.code }} ({{ c.symbol }})
            </option>
        </select>
    </div>
</template>
