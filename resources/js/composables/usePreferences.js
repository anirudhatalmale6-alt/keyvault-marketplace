import { ref } from 'vue';

// Lightweight client-side preference store for currency + language.
// Phase 1 keeps the selection; full price conversion / translation
// wiring lands in the multi-currency and i18n phases.
const read = (key, fallback) => {
    try {
        return localStorage.getItem(key) || fallback;
    } catch (e) {
        return fallback;
    }
};

const currency = ref(read('currency', 'USD'));
const locale = ref(read('locale', 'en'));

export function usePreferences() {
    const setCurrency = (code) => {
        currency.value = code;
        try { localStorage.setItem('currency', code); } catch (e) {}
    };

    const setLocale = (code) => {
        locale.value = code;
        try { localStorage.setItem('locale', code); } catch (e) {}
    };

    return { currency, locale, setCurrency, setLocale };
}
