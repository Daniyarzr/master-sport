<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = Str::slug($data['name']);
        $baseSlug = $slug;
        $counter = 1;

        while (Product::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $data['slug'] = $slug;

        Product::query()->create($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Товар успешно добавлен.');
    }
}
