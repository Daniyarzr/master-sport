<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'user_name', 'user_email',
        'content', 'rating', 'status', 'ip_address',
        'moderator_note', 'approved_at', 'moderated_at', 'moderated_by'
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved_at' => 'datetime',
        'moderated_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SPAM = 'spam';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function getAuthorName(): string
    {
        return $this->user_name ?? $this->user?->name ?? 'Аноним';
    }
}