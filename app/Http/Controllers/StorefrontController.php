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

    /** Public product detail page (Loaded-style). */
    public function product(Product $product): Response
    {
        abort_unless($product->status === 'active', 404);

        $product->load('category');

        $fields = ['id', 'name', 'slug', 'base_price', 'cost_price', 'type', 'category_id', 'meta', 'is_featured'];

        return Inertia::render('Storefront/Product', [
            'product' => [
                'id'                => $product->id,
                'name'              => $product->name,
                'slug'              => $product->slug,
                'short_description' => $product->short_description,
                'description'       => $product->description,
                'type'              => $product->type,
                'base_price'        => $product->base_price,
                'cost_price'        => $product->cost_price,
                'meta'              => $product->meta,
                'in_stock'         => $product->isInStock(),
                'category'          => $product->category
                    ? ['name' => $product->category->name, 'slug' => $product->category->slug]
                    : null,
            ],
            'related' => Product::active()
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(5)->get($fields),
        ]);
    }
}
