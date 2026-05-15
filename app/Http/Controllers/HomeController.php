<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::query()
            ->with(['category', 'collection'])
            ->latest()
            ->limit(4)
            ->get();

        $collections = ProductCollection::query()
            ->withCount('products')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'collections' => $collections,
        ]);
    }
}
