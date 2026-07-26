<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Setting;

/**
 * Central store for the storefront's admin-controllable appearance & content.
 *
 * The whole config lives in a single cached JSON setting (`appearance`), merged
 * over sensible defaults so new keys are always safe. The storefront reads this
 * (shared via Inertia + injected as CSS variables) and the admin panel writes it.
 */
class Appearance
{
    public static function defaults(): array
    {
        return [
            // Branding
            'logo_text'  => Setting::get('site_name', config('app.name')),
            'tagline'    => 'Pay Less. Game More.',
            'font'       => 'Poppins',
            'color_primary' => '#4f46e5', // brand / links / accents
            'color_buy'     => '#2fbf71', // BUY buttons

            // Utility strip + announcement
            'utility_left'  => 'Safe & Secure · 100% secure and 24h support',
            'utility_right' => 'Super Fast · Instant Digital Download',
            'announcement_enabled' => false,
            'announcement_text'    => 'Summer Sale — up to 90% off selected titles!',

            // Hero banner slides
            'hero_slides' => [
                ['title' => 'Summer of Savings', 'subtitle' => 'Up to 90% off games & DLCs', 'cta' => 'Shop deals', 'from' => '#4338ca', 'to' => '#6d28d9'],
                ['title' => 'Earn 5% Cashback', 'subtitle' => 'On all games & DLCs — logged-in users', 'cta' => 'Shop now', 'from' => '#1d4ed8', 'to' => '#0ea5e9'],
                ['title' => 'Gift Cards, Instantly', 'subtitle' => 'PSN, Xbox, Steam, Amazon & more', 'cta' => 'Browse cards', 'from' => '#db2777', 'to' => '#f97316'],
            ],

            // Homepage sections (order + visibility). Category rails are added dynamically.
            'sections' => [
                ['key' => 'best_sellers', 'label' => 'Best Sellers', 'enabled' => true],
                ['key' => 'category_rails', 'label' => 'Category Sections', 'enabled' => true],
                ['key' => 'cta', 'label' => 'Sign-up Call To Action', 'enabled' => true],
            ],

            // Which top-level categories appear on the homepage (slugs). Empty = all.
            'homepage_categories' => [],

            // Footer
            'footer_about' => null, // null => auto text
        ];
    }

    /** Full merged config (cached). */
    public static function all(): array
    {
        $stored = Setting::get('appearance');
        $stored = is_array($stored) ? $stored : [];

        return array_replace(static::defaults(), $stored);
    }

    /** Persist a full config array. */
    public static function update(array $config): void
    {
        // Only keep known keys so the blob stays clean.
        $clean = array_intersect_key($config, static::defaults());
        Setting::set('appearance', $clean, 'json', 'appearance');
    }

    /** Fonts offered in the admin picker (must be available on Bunny Fonts). */
    public static function fonts(): array
    {
        return ['Poppins', 'Inter', 'Montserrat', 'Roboto', 'Nunito', 'Rubik', 'Figtree'];
    }
}
