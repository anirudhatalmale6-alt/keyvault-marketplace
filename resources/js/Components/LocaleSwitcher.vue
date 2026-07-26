<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePreferences } from '@/composables/usePreferences';

const page = usePage();
const labels = { en: 'English', fr: 'Français', ar: 'العربية' };
const locales = computed(() => page.props.locales || ['en']);
const { locale, setLocale } = usePreferences();
</script>

<template>
    <select
        :value="locale"
        @change="setLocale($event.target.value)"
        aria-label="Select language"
        class="cursor-pointer rounded-lg border-gray-200 bg-white py-1.5 pl-3 pr-8 text-sm text-gray-700 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
    >
        <option v-for="l in locales" :key="l" :value="l">{{ labels[l] || l }}</option>
    </select>
</template>
