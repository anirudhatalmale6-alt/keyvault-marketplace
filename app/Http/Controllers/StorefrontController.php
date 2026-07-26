<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class StorefrontController extends Controller
{
    /** Public storefront landing page. */
    public function home(): Response
    {
        $fields = ['id', 'name', 'slug', 'base_price', 'cost_price', 'type', 'category_id', 'meta', 'is_featured'];

        $categories = Category::active()->roots()->orderBy('position')
            ->get(['id', 'name', 'slug', 'icon']);

        // Build a product rail per top-level category.
        $rails = $categories->map(function (Category $category) use ($fields) {
            return [
                'title'    => $category->name,
                'slug'     => $category->slug,
                'products' => Product::active()->where('category_id', $category->id)
                    ->latest('id')->limit(12)->get($fields),
            ];
        })->filter(fn ($rail) => $rail['products']->isNotEmpty())->values();

        return Inertia::render('Storefront/Home', [
            'categories' => $categories,
            'featured'   => Product::active()->featured()->limit(8)->get($fields),
            'rails'      => $rails,
            'stats'      => [
                'products'   => Product::active()->count(),
                'categories' => Category::active()->count(),
                'customers'  => User::where('role', 'customer')->count(),
            ],
        ]);
    }
}
