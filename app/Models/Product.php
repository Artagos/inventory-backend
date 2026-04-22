<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'min_threshold',
        'category_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'min_threshold' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_threshold;
    }

    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 'min_threshold');
    }
}
