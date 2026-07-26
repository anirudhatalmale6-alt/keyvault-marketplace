import { ref } from 'vue';

// Global reactive theme state shared across all components.
const isDark = ref(
    typeof document !== 'undefined' &&
    document.documentElement.classList.contains('dark')
);

export function useTheme() {
    const apply = (dark) => {
        isDark.value = dark;
        document.documentElement.classList.toggle('dark', dark);
        try {
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        } catch (e) {}
    };

    const toggle = () => apply(!isDark.value);

    return { isDark, toggle, apply };
}
