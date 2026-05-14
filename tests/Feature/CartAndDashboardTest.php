<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cart_page(): void
    {
        $this->get(route('cart.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_add_to_cart_in_database_and_checkout_with_delivery(): void
    {
        $category = Category::query()->create([
            'name' => 'T-Shirts',
            'slug' => 'tshirts',
        ]);

        $collection = ProductCollection::query()->create([
            'name' => 'Core Line',
            'slug' => 'core-line',
            'is_active' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'collection_id' => $collection->id,
            'name' => 'Test Tee',
            'slug' => Str::slug('Test Tee'),
            'description' => 'Test description',
            'price' => 3000,
            'stock' => 5,
            'image' => 'products/test.svg',
            'gender' => 'unisex',
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user)
            ->post(route('cart.checkout'), [
                'customer_name' => 'Updated User',
                'customer_email' => 'updated@example.com',
                'customer_phone' => '+79990000011',
                'delivery_type' => 'delivery',
                'delivery_address' => 'Izhevsk, Pushkinskaya 1',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'customer_name' => 'Updated User',
            'status' => 'new',
            'delivery_type' => 'delivery',
            'delivery_cost' => 300,
            'delivery_address' => 'Izhevsk, Pushkinskaya 1',
            'total' => 6300,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 3,
        ]);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_checkout_with_pickup_without_delivery_address(): void
    {
        $category = Category::query()->create([
            'name' => 'Hoodies',
            'slug' => 'hoodies',
        ]);

        $collection = ProductCollection::query()->create([
            'name' => 'Street',
            'slug' => 'street',
            'is_active' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'collection_id' => $collection->id,
            'name' => 'Test Hoodie',
            'slug' => Str::slug('Test Hoodie'),
            'description' => 'Test hoodie',
            'price' => 4500,
            'stock' => 4,
            'image' => 'products/test-hoodie.svg',
            'gender' => 'unisex',
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['quantity' => 1])
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('cart.checkout'), [
                'customer_name' => 'Pickup User',
                'customer_email' => 'pickup@example.com',
                'customer_phone' => '+79990000012',
                'delivery_type' => 'pickup',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'delivery_type' => 'pickup',
            'delivery_cost' => 0,
            'delivery_address' => 'г. Ижевск, Пушкинская 268',
            'total' => 4500,
        ]);
    }

    public function test_user_can_update_profile_data_in_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('dashboard.profile.update'), [
                'name' => 'Updated Profile',
                'email' => 'new-profile@example.com',
                'phone' => '+79991112233',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Profile',
            'email' => 'new-profile@example.com',
            'phone' => '+79991112233',
        ]);
    }
}
