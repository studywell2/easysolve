<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_students',
        'max_staff',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_monthly' => 'decimal:2',
            'price_yearly' => 'decimal:2',
            'features' => 'array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'max_students' => 'integer',
            'max_staff' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // ─── Scopes ────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ─── Helpers ───────────────────────────────────────

    public function getFormattedMonthlyAttribute(): string
    {
        return $this->price_monthly > 0
            ? config('platform.currency_symbol', '₦').number_format((float) $this->price_monthly)
            : 'Free';
    }

    public function getFormattedYearlyAttribute(): string
    {
        return $this->price_yearly > 0
            ? config('platform.currency_symbol', '₦').number_format((float) $this->price_yearly)
            : 'Free';
    }
}
