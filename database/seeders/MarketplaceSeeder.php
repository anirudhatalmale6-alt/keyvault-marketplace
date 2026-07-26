<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        // --- Currencies (base = USD) -----------------------------------
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1, 'is_default' => true, 'position' => 1],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.92, 'is_default' => false, 'position' => 2],
            ['code' => 'DZD', 'name' => 'Algerian Dinar', 'symbol' => 'DA', 'exchange_rate' => 134.50, 'is_default' => false, 'position' => 3],
        ];
        foreach ($currencies as $c) {
            Currency::updateOrCreate(['code' => $c['code']], $c);
        }

        // --- Core settings ---------------------------------------------
        Setting::set('site_name', 'KeyVault', 'string');
        Setting::set('site_tagline', 'Instant digital delivery — game keys, gift cards & more', 'string');
        Setting::set('base_currency', 'USD', 'string');
        Setting::set('default_locale', 'en', 'string');
        Setting::set('supported_locales', ['en', 'fr', 'ar'], 'json');
        Setting::set('default_profit_margin', 15, 'integer'); // percent

        // --- Categories (top level) ------------------------------------
        $categories = [
            ['name' => 'Game Keys', 'slug' => 'game-keys', 'icon' => 'gamepad', 'position' => 1],
            ['name' => 'Gift Cards', 'slug' => 'gift-cards', 'icon' => 'gift', 'position' => 2],
            ['name' => 'Subscriptions', 'slug' => 'subscriptions', 'icon' => 'refresh', 'position' => 3],
            ['name' => 'Prepaid Cards', 'slug' => 'prepaid-cards', 'icon' => 'credit-card', 'position' => 4],
        ];
        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // --- Admin account ---------------------------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@keyvault.test'],
            [
                'name'     => 'Store Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'currency' => 'USD',
            ],
        );
        // email_verified_at is guarded against mass assignment — set it directly.
        if (! $admin->hasVerifiedEmail()) {
            $admin->markEmailAsVerified();
        }
        $admin->ensureWallet();
    }
}
