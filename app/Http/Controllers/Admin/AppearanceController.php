<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Appearance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppearanceController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Appearance', [
            'config'     => Appearance::all(),
            'fonts'      => Appearance::fonts(),
            'categories' => Category::active()->roots()->orderBy('position')->get(['name', 'slug']),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'logo_text'  => ['required', 'string', 'max:60'],
            'tagline'    => ['nullable', 'string', 'max:120'],
            'font'       => ['required', 'string', 'max:40'],
            'color_primary' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'color_buy'     => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'utility_left'  => ['nullable', 'string', 'max:120'],
            'utility_right' => ['nullable', 'string', 'max:120'],
            'announcement_enabled' => ['boolean'],
            'announcement_text'    => ['nullable', 'string', 'max:160'],
            'hero_slides'          => ['array'],
            'hero_slides.*.title'    => ['nullable', 'string', 'max:80'],
            'hero_slides.*.subtitle' => ['nullable', 'string', 'max:140'],
            'hero_slides.*.cta'      => ['nullable', 'string', 'max:40'],
            'hero_slides.*.from'     => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'hero_slides.*.to'       => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'sections'               => ['array'],
            'sections.*.key'         => ['required', 'string'],
            'sections.*.label'       => ['required', 'string'],
            'sections.*.enabled'     => ['boolean'],
            'homepage_categories'    => ['array'],
            'homepage_categories.*'  => ['string'],
            'footer_about'           => ['nullable', 'string', 'max:600'],
        ]);

        Appearance::update($data);

        return back()->with('success', 'Appearance updated. Your storefront has been refreshed.');
    }
}
