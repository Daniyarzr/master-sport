<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@mastersport.ru'],
            [
                'name' => 'Admin',
                'phone' => '+79000000000',
                'role' => User::ROLE_ADMIN,
                'password' => Hash::make('password'),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '+79000000001',
                'role' => User::ROLE_USER,
                'password' => Hash::make('password'),
            ]
        );

        $categories = collect([
            ['name' => 'Футболки', 'slug' => 'tshirts', 'description' => 'Базовые и тренировочные футболки для спорта и города.'],
            ['name' => 'Шорты', 'slug' => 'shorts', 'description' => 'Легкие шорты для бега, фитнеса и активного дня.'],
            ['name' => 'Худи', 'slug' => 'hoodies', 'description' => 'Свободные худи и утепленные модели для прохладной погоды.'],
        ])->mapWithKeys(function (array $category): array {
            $model = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );

            return [$category['name'] => $model];
        });

        $collections = collect([
            ['name' => 'Core Line', 'description' => 'Повседневная спортивная база.'],
            ['name' => 'Run Focus', 'description' => 'Легкая экипировка для бега и кардио.'],
            ['name' => 'Urban Move', 'description' => 'Современный спорт-стиль для города.'],
        ])->mapWithKeys(function (array $collection): array {
            $slug = Str::slug($collection['name']);

            $model = ProductCollection::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $collection['name'],
                    'description' => $collection['description'],
                    'is_active' => true,
                ]
            );

            return [$collection['name'] => $model];
        });

        $products = [
            [
                'name' => 'Aero Tee Blue',
                'description' => 'Легкая футболка из дышащей ткани для ежедневных тренировок.',
                'price' => 3490,
                'stock' => 30,
                'brand' => 'Master Sport',
                'size' => 'S-XL',
                'color' => 'Blue',
                'gender' => 'unisex',
                'category' => 'Футболки',
                'collection' => 'Run Focus',
                'image' => 'storage/products/aero-tee-blue.svg',
            ],
            [
                'name' => 'Flow Tee Sand',
                'description' => 'Базовая футболка с мягкой фактурой и свободной посадкой.',
                'price' => 3290,
                'stock' => 19,
                'brand' => 'Master Sport',
                'size' => 'S-XL',
                'color' => 'Sand',
                'gender' => 'unisex',
                'category' => 'Футболки',
                'collection' => 'Core Line',
                'image' => 'storage/products/flow-tee-sand.svg',
            ],
            [
                'name' => 'Sprint Shorts Orange',
                'description' => 'Эластичные шорты с мягкой поддержкой и удобной посадкой.',
                'price' => 2990,
                'stock' => 22,
                'brand' => 'Master Sport',
                'size' => 'S-L',
                'color' => 'Orange',
                'gender' => 'unisex',
                'category' => 'Шорты',
                'collection' => 'Core Line',
                'image' => 'storage/products/sprint-shorts-orange.svg',
            ],
            [
                'name' => 'Runline Shorts Black',
                'description' => 'Беговые шорты с внутренним карманом и комфортной резинкой.',
                'price' => 3190,
                'stock' => 26,
                'brand' => 'Master Sport',
                'size' => 'S-XL',
                'color' => 'Black',
                'gender' => 'unisex',
                'category' => 'Шорты',
                'collection' => 'Run Focus',
                'image' => 'storage/products/runline-shorts-black.svg',
            ],
            [
                'name' => 'Flex Hoodie Graphite',
                'description' => 'Худи свободного кроя с плотной тканью и капюшоном.',
                'price' => 4590,
                'stock' => 15,
                'brand' => 'Master Sport',
                'size' => 'M-XL',
                'color' => 'Graphite',
                'gender' => 'unisex',
                'category' => 'Худи',
                'collection' => 'Urban Move',
                'image' => 'storage/products/flex-hoodie-graphite.svg',
            ],
            [
                'name' => 'Urban Hoodie Clay',
                'description' => 'Плотный худи в приглушенном оттенке для городского ритма.',
                'price' => 4890,
                'stock' => 11,
                'brand' => 'Master Sport',
                'size' => 'M-XL',
                'color' => 'Clay',
                'gender' => 'unisex',
                'category' => 'Худи',
                'collection' => 'Urban Move',
                'image' => 'storage/products/urban-hoodie-clay.svg',
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                    'brand' => $product['brand'],
                    'size' => $product['size'],
                    'color' => $product['color'],
                    'gender' => $product['gender'],
                    'category_id' => $categories[$product['category']]->id,
                    'collection_id' => $collections[$product['collection']]->id,
                ]
            );
        }

        $stocks = [
            [
                'title' => '−20% на коллекцию Run Focus',
                'description' => "Скидка 20% на все товары линейки Run Focus: беговые футболки и шорты.\n\nАкция действует в магазине и онлайн. Скидка применяется автоматически при оформлении заказа.",
                'image_path' => 'storage/products/aero-tee-blue.svg',
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Весенняя распродажа худи',
                'description' => "Скидки до 15% на худи Urban Move и Flex Hoodie.\n\nУспейте обновить гардероб к сезону — количество товаров ограничено.",
                'image_path' => 'storage/products/flex-hoodie-graphite.svg',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(45),
            ],
            [
                'title' => '2 футболки — третья в подарок',
                'description' => "При покупке двух футболок из каталога третья модель Core Line — в подарок.\n\nПредложение для зарегистрированных пользователей. Подробности у консультантов.",
                'image_path' => 'storage/products/flow-tee-sand.svg',
                'start_date' => now(),
                'end_date' => now()->addDays(60),
            ],
        ];

        foreach ($stocks as $stock) {
            Stock::query()->updateOrCreate(
                ['title' => $stock['title']],
                $stock
            );
        }
    }
}
