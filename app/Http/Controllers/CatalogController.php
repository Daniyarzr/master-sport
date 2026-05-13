<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'collection'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = trim((string) $request->input('search'));
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->where('category_id', (int) $request->input('category'));
            })
            ->when($request->filled('collection'), function ($query) use ($request): void {
                $query->where('collection_id', (int) $request->input('collection'));
            })
            ->orderBy('name')
            ->simplePaginate(12)
            ->withQueryString();

        return view('catalog', [
            'products' => $products,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'collections' => ProductCollection::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name']),
            'filters' => [
                'search' => (string) $request->input('search', ''),
                'category' => (string) $request->input('category', ''),
                'collection' => (string) $request->input('collection', ''),
            ],
        ]);
    }
}
