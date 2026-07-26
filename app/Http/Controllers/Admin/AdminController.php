<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function dashboard(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'products'   => Product::count(),
                'active'     => Product::active()->count(),
                'categories' => Category::count(),
                'orders'     => Order::count(),
                'customers'  => User::where('role', 'customer')->count(),
                'revenue'    => (float) Order::where('payment_status', 'paid')->sum('total'),
            ],
        ]);
    }
}
