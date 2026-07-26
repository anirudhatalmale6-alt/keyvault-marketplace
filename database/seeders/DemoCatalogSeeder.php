<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoCatalogSeeder extends Seeder
{
    /**
     * Realistic demo products so the storefront looks populated.
     * Real artwork/pricing will be replaced by supplier imports in Phase 3.
     * Each product carries a gradient + platform in meta for the card visuals.
     */
    public function run(): void
    {
        $gradients = [
            ['#4f46e5', '#0ea5e9'], ['#db2777', '#f97316'], ['#059669', '#84cc16'],
            ['#7c3aed', '#ec4899'], ['#ea580c', '#facc15'], ['#0891b2', '#22d3ee'],
            ['#dc2626', '#f59e0b'], ['#2563eb', '#7c3aed'], ['#16a34a', '#14b8a6'],
            ['#9333ea', '#4f46e5'],
        ];

        $catalog = [
            'game-keys' => [
                'type' => 'game_key',
                'items' => [
                    ['Cyberpunk 2077', 29.99, 22.00, 'PC / Steam'],
                    ['Elden Ring', 44.99, 34.00, 'PC / Steam'],
                    ['EA SPORTS FC 25', 54.99, 41.00, 'PC / Origin'],
                    ['Call of Duty: MW III', 59.99, 47.00, 'PC / Battle.net'],
                    ['Red Dead Redemption 2', 24.99, 17.50, 'PC / Rockstar'],
                    ['Hogwarts Legacy', 39.99, 30.00, 'PC / Steam'],
                    ['Grand Theft Auto V', 14.99, 9.00, 'PC / Rockstar'],
                    ["Baldur's Gate 3", 49.99, 39.00, 'PC / Steam'],
                ],
            ],
            'gift-cards' => [
                'type' => 'gift_card',
                'items' => [
                    ['Steam Wallet $50', 50.00, 47.50, 'Global'],
                    ['PlayStation Store $50', 50.00, 47.00, 'US'],
                    ['Xbox Gift Card $25', 25.00, 23.50, 'US'],
                    ['Amazon Gift Card $50', 50.00, 48.50, 'US'],
                    ['Google Play $25', 25.00, 23.00, 'US'],
                    ['App Store & iTunes $25', 25.00, 23.00, 'US'],
                    ['Netflix Gift Card $30', 30.00, 28.00, 'US'],
                    ['Spotify Premium $30', 30.00, 27.50, 'US'],
                ],
            ],
            'subscriptions' => [
                'type' => 'subscription',
                'items' => [
                    ['Xbox Game Pass Ultimate 3M', 44.99, 34.00, 'Global'],
                    ['PlayStation Plus 12M', 59.99, 48.00, 'US'],
                    ['Nintendo Switch Online 12M', 19.99, 15.00, 'US'],
                    ['Discord Nitro 1M', 9.99, 7.50, 'Global'],
                    ['YouTube Premium 3M', 23.99, 18.00, 'Global'],
                    ['NordVPN 12M', 59.99, 39.00, 'Global'],
                ],
            ],
            'prepaid-cards' => [
                'type' => 'prepaid',
                'items' => [
                    ['PUBG Mobile 660 UC', 9.99, 7.20, 'Global'],
                    ['Free Fire 1000 Diamonds', 9.49, 6.80, 'Global'],
                    ['Valorant 1000 Points', 9.99, 7.60, 'NA'],
                    ['Mobile Legends 500 Diamonds', 9.99, 7.40, 'Global'],
                    ['Roblox 800 Robux', 9.99, 8.10, 'Global'],
                    ['Razer Gold $10', 10.00, 9.20, 'Global'],
                ],
            ],
        ];

        $i = 0;
        foreach ($catalog as $slug => $group) {
            $category = Category::where('slug', $slug)->first();
            if (! $category) {
                continue;
            }

            foreach ($group['items'] as $idx => [$name, $price, $cost, $region]) {
                $g = $gradients[$i % count($gradients)];
                $i++;

                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'category_id'      => $category->id,
                        'name'             => $name,
                        'sku'              => 'DEMO-'.strtoupper(Str::random(6)),
                        'short_description'=> "Instant digital delivery. {$region} region.",
                        'description'      => "Buy {$name} and receive your code instantly after payment. Genuine, region: {$region}. Delivered to your account and email automatically.",
                        'type'             => $group['type'],
                        'fulfillment'      => 'manual',
                        'base_price'       => $price,
                        'cost_price'       => $cost,
                        'stock'            => 25,
                        'status'           => 'active',
                        'is_featured'      => $idx < 2,
                        'meta'             => [
                            'platform' => $region,
                            'gradient' => $g,
                        ],
                    ],
                );

                // Give each product a few available demo keys.
                if ($product->keys()->count() === 0) {
                    for ($k = 0; $k < 5; $k++) {
                        ProductKey::create([
                            'product_id' => $product->id,
                            'code'       => strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4).'-'.Str::random(4)),
                            'status'     => 'available',
                        ]);
                    }
                }
            }
        }
    }
}
