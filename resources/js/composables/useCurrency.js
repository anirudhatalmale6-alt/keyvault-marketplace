import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { usePreferences } from '@/composables/usePreferences';

// Converts base-currency (USD) amounts into the visitor's selected currency
// using the exchange rates shared from the backend, and formats them.
export function useCurrency() {
    const page = usePage();
    const { currency } = usePreferences();

    const active = computed(() => {
        const list = page.props.currencies || [];
        return list.find((c) => c.code === currency.value) || list.find((c) => c.is_default) || { code: 'USD', symbol: '$', exchange_rate: 1 };
    });

    const format = (baseAmount) => {
        const c = active.value;
        const value = Number(baseAmount || 0) * Number(c.exchange_rate || 1);
        const formatted = value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        return `${c.symbol}${formatted}`;
    };

    return { format, active, currency };
}
