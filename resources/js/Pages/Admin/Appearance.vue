<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    config: { type: Object, required: true },
    fonts: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
});

const page = usePage();
const flash = computed(() => page.props.flash || {});

const form = useForm({
    logo_text: props.config.logo_text,
    tagline: props.config.tagline,
    font: props.config.font,
    color_primary: props.config.color_primary,
    color_buy: props.config.color_buy,
    utility_left: props.config.utility_left,
    utility_right: props.config.utility_right,
    announcement_enabled: !!props.config.announcement_enabled,
    announcement_text: props.config.announcement_text,
    hero_slides: JSON.parse(JSON.stringify(props.config.hero_slides || [])),
    sections: JSON.parse(JSON.stringify(props.config.sections || [])),
    homepage_categories: [...(props.config.homepage_categories || [])],
    footer_about: props.config.footer_about,
});

const addSlide = () => form.hero_slides.push({ title: '', subtitle: '', cta: 'Shop now', from: '#4338ca', to: '#6d28d9' });
const removeSlide = (i) => form.hero_slides.splice(i, 1);

const moveSection = (i, dir) => {
    const j = i + dir;
    if (j < 0 || j >= form.sections.length) return;
    const arr = form.sections;
    [arr[i], arr[j]] = [arr[j], arr[i]];
};

const toggleCategory = (slug) => {
    const i = form.homepage_categories.indexOf(slug);
    if (i === -1) form.homepage_categories.push(slug);
    else form.homepage_categories.splice(i, 1);
};

const submit = () => form.put(route('admin.appearance.update'), { preserveScroll: true });
</script>

<template>
    <Head title="Admin — Appearance" />
    <AdminLayout>
        <template #title><h1 class="text-lg font-bold">Appearance</h1></template>

        <div v-if="flash.success" class="mb-6 rounded-lg bg-buy/15 px-4 py-3 text-sm font-medium text-buy">{{ flash.success }}</div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Branding -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <h2 class="text-base font-bold">Branding</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Logo text</span>
                        <input v-model="form.logo_text" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Tagline</span>
                        <input v-model="form.tagline" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Font</span>
                        <select v-model="form.font" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800">
                            <option v-for="f in fonts" :key="f" :value="f">{{ f }}</option>
                        </select>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Primary color</span>
                            <div class="mt-1 flex items-center gap-2">
                                <input v-model="form.color_primary" type="color" class="h-9 w-12 rounded border-gray-300 dark:border-navy-600" />
                                <input v-model="form.color_primary" type="text" class="w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                            </div>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Buy button color</span>
                            <div class="mt-1 flex items-center gap-2">
                                <input v-model="form.color_buy" type="color" class="h-9 w-12 rounded border-gray-300 dark:border-navy-600" />
                                <input v-model="form.color_buy" type="text" class="w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Announcement + utility -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <h2 class="text-base font-bold">Top bar</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Utility strip — left</span>
                        <input v-model="form.utility_left" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Utility strip — right</span>
                        <input v-model="form.utility_right" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                    </label>
                </div>
                <label class="mt-4 flex items-center gap-2">
                    <input v-model="form.announcement_enabled" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary" />
                    <span class="text-sm font-medium">Show announcement bar</span>
                </label>
                <input v-model="form.announcement_text" type="text" placeholder="Announcement text" class="mt-2 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
            </section>

            <!-- Hero banners -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold">Hero banners</h2>
                    <button type="button" @click="addSlide" class="rounded-lg bg-primary px-3 py-1.5 text-sm font-semibold text-white hover:brightness-110">+ Add slide</button>
                </div>
                <div class="mt-4 space-y-4">
                    <div v-for="(s, i) in form.hero_slides" :key="i" class="rounded-lg border border-gray-200 p-4 dark:border-navy-700">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input v-model="s.title" placeholder="Title" class="rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                            <input v-model="s.cta" placeholder="Button text" class="rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800" />
                            <input v-model="s.subtitle" placeholder="Subtitle" class="rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800 sm:col-span-2" />
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">Gradient from</span>
                                <input v-model="s.from" type="color" class="h-8 w-10 rounded border-gray-300 dark:border-navy-600" />
                                <span class="text-xs text-gray-500">to</span>
                                <input v-model="s.to" type="color" class="h-8 w-10 rounded border-gray-300 dark:border-navy-600" />
                            </div>
                            <div class="flex items-center justify-end">
                                <button type="button" @click="removeSlide(i)" class="text-sm font-medium text-red-500 hover:underline">Remove</button>
                            </div>
                        </div>
                        <div class="mt-3 h-12 rounded-lg" :style="{ background: `linear-gradient(135deg, ${s.from}, ${s.to})` }"></div>
                    </div>
                </div>
            </section>

            <!-- Homepage sections -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <h2 class="text-base font-bold">Homepage sections</h2>
                <p class="mt-1 text-sm text-gray-500">Toggle visibility and reorder.</p>
                <ul class="mt-4 space-y-2">
                    <li v-for="(sec, i) in form.sections" :key="sec.key" class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-2 dark:border-navy-700">
                        <input v-model="sec.enabled" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary" />
                        <span class="flex-1 text-sm font-medium">{{ sec.label }}</span>
                        <button type="button" @click="moveSection(i, -1)" class="rounded p-1 hover:bg-gray-100 dark:hover:bg-navy-700" aria-label="Move up">▲</button>
                        <button type="button" @click="moveSection(i, 1)" class="rounded p-1 hover:bg-gray-100 dark:hover:bg-navy-700" aria-label="Move down">▼</button>
                    </li>
                </ul>
            </section>

            <!-- Homepage categories -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <h2 class="text-base font-bold">Categories on homepage</h2>
                <p class="mt-1 text-sm text-gray-500">Leave all unchecked to show every category.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <label v-for="c in categories" :key="c.slug" class="flex cursor-pointer items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 dark:border-navy-700">
                        <input type="checkbox" :checked="form.homepage_categories.includes(c.slug)" @change="toggleCategory(c.slug)" class="rounded border-gray-300 text-primary focus:ring-primary" />
                        <span class="text-sm">{{ c.name }}</span>
                    </label>
                </div>
            </section>

            <!-- Footer -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 dark:border-navy-800 dark:bg-navy-850">
                <h2 class="text-base font-bold">Footer</h2>
                <label class="mt-4 block">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">About text</span>
                    <textarea v-model="form.footer_about" rows="3" placeholder="Leave blank for the default description" class="mt-1 w-full rounded-lg border-gray-300 text-sm dark:border-navy-600 dark:bg-navy-800"></textarea>
                </label>
            </section>

            <!-- Save bar -->
            <div class="sticky bottom-0 flex items-center justify-end gap-3 rounded-xl border border-gray-200 bg-white/95 p-4 backdrop-blur dark:border-navy-800 dark:bg-navy-850/95">
                <span v-if="form.recentlySuccessful" class="text-sm text-buy">Saved!</span>
                <a href="/" target="_blank" class="text-sm font-medium text-gray-500 hover:text-primary">Preview store ↗</a>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white transition hover:brightness-110 disabled:opacity-50">
                    {{ form.processing ? 'Saving…' : 'Save changes' }}
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
