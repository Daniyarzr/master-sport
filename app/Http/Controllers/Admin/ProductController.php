<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()
                ->with(['category', 'collection'])
                ->orderByDesc('created_at')
                ->paginate(20),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'collections' => ProductCollection::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'collections' => ProductCollection::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->storeImageForHosting($request->file('image'));
        } catch (\Throwable $exception) {
            return back()->withErrors([
                'image' => $exception->getMessage(),
            ])->withInput();
        }

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
            ->route('admin.products.index')
            ->with('status', 'Товар успешно добавлен.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'collection_id' => ['nullable', 'exists:product_collections,id'],
            'brand' => ['nullable', 'string', 'max:120'],
            'size' => ['nullable', 'string', 'max:40'],
            'color' => ['nullable', 'string', 'max:80'],
            'gender' => ['required', 'in:unisex,male,female'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
        ]);

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Товар обновлён.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('status', 'Товар удалён.');
    }

    private function storeImageForHosting(?UploadedFile $image): string
    {
        if (! $image) {
            return 'storage/products/no-image.png';
        }

        $extension = strtolower($image->getClientOriginalExtension() ?: 'jpg');
        $fileName = Str::uuid().'.'.$extension;

        // стандартное сохранение через public 
        $stored = $image->storeAs('products', $fileName, 'public');
        if ($stored) {
            return 'storage/'.str_replace('\\', '/', $stored);
        }

        // сохранение в папку public_html/storage/products (на случай, если нет симлинка или проблемы с правами на папку storage)
        $publicProductsDir = public_path('storage/products');
        if (! is_dir($publicProductsDir)) {
            @mkdir($publicProductsDir, 0755, true);
        }

        if (! is_dir($publicProductsDir) || ! is_writable($publicProductsDir)) {
            throw new \RuntimeException(
                'Не удалось сохранить изображение. Проверьте права на папки storage и public_html/storage.'
            );
        }

        $image->move($publicProductsDir, $fileName);

        return 'storage/products/'.$fileName;
    }
}
