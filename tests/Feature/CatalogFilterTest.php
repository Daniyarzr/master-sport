<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatalogFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_can_filter_products_by_price_range(): void
    {
        $category = Category::query()->create([
            'name' => 'Tops',
            'slug' => 'tops',
        ]);

        $collection = ProductCollection::query()->create([
            'name' => 'Base',
            'slug' => 'base',
            'is_active' => true,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'collection_id' => $collection->id,
            'name' => 'Cheap Tee',
            'slug' => Str::slug('Cheap Tee'),
            'description' => 'Cheap',
            'price' => 1000,
            'stock' => 5,
            'image' => 'products/cheap.svg',
            'gender' => 'unisex',
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'collection_id' => $collection->id,
            'name' => 'Mid Tee',
            'slug' => Str::slug('Mid Tee'),
            'description' => 'Mid',
            'price' => 3000,
            'stock' => 5,
            'image' => 'products/mid.svg',
            'gender' => 'unisex',
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'collection_id' => $collection->id,
            'name' => 'Expensive Tee',
            'slug' => Str::slug('Expensive Tee'),
            'description' => 'Expensive',
            'price' => 5000,
            'stock' => 5,
            'image' => 'products/expensive.svg',
            'gender' => 'unisex',
        ]);

        $this->get(route('catalog', [
            'price_from' => 2000,
            'price_to' => 4000,
        ]))
            ->assertOk()
            ->assertSee('Mid Tee')
            ->assertDontSee('Cheap Tee')
            ->assertDontSee('Expensive Tee');
    }
}
