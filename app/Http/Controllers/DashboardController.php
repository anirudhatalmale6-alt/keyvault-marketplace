<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /** Authenticated customer dashboard. */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $wallet = $user->ensureWallet();

        return Inertia::render('Dashboard', [
            'wallet' => [
                'balance'  => (float) $wallet->balance,
                'currency' => $wallet->currency,
            ],
            'referral' => [
                'code'  => $user->referral_code,
                'count' => $user->referrals()->count(),
            ],
            'stats' => [
                'orders'    => $user->orders()->count(),
                'completed' => $user->orders()->completed()->count(),
                'wishlist'  => $user->wishlists()->count(),
            ],
            'recentOrders' => $user->orders()->latest()->limit(5)->get([
                'id', 'order_number', 'status', 'total', 'currency', 'created_at',
            ]),
        ]);
    }
}
