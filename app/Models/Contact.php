<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'key',
        'type',
        'label',
        'value',
        'href',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getResolvedHrefAttribute(): ?string
    {
        if ($this->type === 'phone') {
            $digits = preg_replace('/[^\d+]/', '', $this->value);

            return $digits ? 'tel:'.$digits : null;
        }

        if ($this->type === 'email') {
            return 'mailto:'.$this->value;
        }

        return $this->href !== '' ? $this->href : null;
    }
}
