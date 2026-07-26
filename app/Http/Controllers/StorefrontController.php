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
        return Inertia::render('Storefront/Home', [
            'categories' => Category::active()->roots()->orderBy('position')
                ->get(['id', 'name', 'slug', 'icon']),
            'stats' => [
                'products'   => Product::active()->count(),
                'categories' => Category::active()->count(),
                'customers'  => User::where('role', 'customer')->count(),
            ],
        ]);
    }
}
