<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API routes (v1)
|--------------------------------------------------------------------------
| Token-authenticated REST API (Laravel Sanctum). This is the foundation the
| mobile app / external integrations and the supplier & marketplace engines
| will build on in later phases.
*/

Route::prefix('v1')->group(function () {
    // Public catalog endpoints
    Route::get('/categories', fn () => Category::active()->roots()->orderBy('position')->get());

    Route::get('/products', function (Request $request) {
        return Product::active()
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->paginate(24);
    });

    Route::get('/products/{product:slug}', fn (Product $product) => $product->load('category'));

    // Authenticated endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', fn (Request $request) => $request->user());
        Route::get('/wallet', fn (Request $request) => $request->user()->ensureWallet());
        Route::get('/orders', fn (Request $request) => $request->user()->orders()->latest()->paginate(20));
    });
});
