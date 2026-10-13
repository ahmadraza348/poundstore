<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'tag',
        'image',
        'description',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_featured' => 'boolean',
        'status'      => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Full public URL of the product image (null when no image uploaded). */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
}
