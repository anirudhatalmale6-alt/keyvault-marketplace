<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            // Shared storefront chrome — available on every page.
            'site' => [
                'name'    => Setting::get('site_name', config('app.name')),
                'tagline' => Setting::get('site_tagline', ''),
            ],
            'currencies' => fn () => Currency::active()->orderBy('position')
                ->get(['code', 'name', 'symbol', 'exchange_rate', 'is_default']),
            'locales' => Setting::get('supported_locales', ['en']),
            'navCategories' => fn () => Category::active()->roots()->orderBy('position')
                ->get(['id', 'name', 'slug', 'icon']),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
