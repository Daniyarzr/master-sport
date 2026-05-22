<?php

namespace App\Models;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'collection_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'brand',
        'size',
        'color',
        'gender',
    ];
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class, 'collection_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Вспомогательный метод: только одобренные отзывы (для частого использования)
     */
    public function approvedReviews(): HasMany
    {
        return $this->reviews()->where('status', Review::STATUS_APPROVED);
    }

    /**
     * Средний рейтинг товара (кэшируемый)
     */
    public function getAverageRatingAttribute(): float
    {
        return \Illuminate\Support\Facades\Cache::remember(
            "product_{$this->id}_rating",
            3600,
            fn() => $this->approvedReviews()->avg('rating') ?? 0
        );
    }
}
