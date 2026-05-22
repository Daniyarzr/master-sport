<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:10|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'user_name' => 'nullable|string|max:100',
            'user_email' => 'nullable|email|max:255',
        ]);

        // Защита от дублей: 1 отзыв на товар от пользователя
        if (Auth::check()) {
            $exists = Review::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->where('status', '!=', Review::STATUS_REJECTED)
                ->exists();
            if ($exists) {
                return back()->withErrors(['content' => 'Вы уже оставляли отзыв на этот товар.']);
            }
        }

        // Анти-спам: проверка по IP (не более 3 отзывов в час)
        $ip = $request->ip();
        $recentCount = Review::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHour())
            ->count();
        if ($recentCount >= 3) {
            return back()->withErrors(['content' => 'Слишком много отзывов. Попробуйте позже.']);
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'user_name' => $validated['user_name'] ?? (Auth::check() ? Auth::user()->name : null),
            'user_email' => $validated['user_email'] ?? (Auth::check() ? Auth::user()->email : null),
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'status' => Review::STATUS_PENDING,
            'ip_address' => $ip,
        ]);

        // Сброс кэша рейтинга товара
        Cache::forget("product_{$product->id}_rating");

        return back()->with('success', 'Спасибо! Ваш отзыв отправлен на модерацию.');
    }

    public function index(Product $product)
    {
        // Кэшируем одобренные отзывы на 15 минут
        return $product->reviews()
        ->where('status', Review::STATUS_APPROVED)
        ->with('user:id,name') // загружаем только нужные поля
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
    }

    public function averageRating(Product $product): float
    {
        return Cache::remember(
            "product_{$product->id}_rating",
            3600,
            fn() => $product->approvedReviews()->avg('rating') ?? 0
        );
    }
}