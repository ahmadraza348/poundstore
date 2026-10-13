<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'image', 'is_featured', 'description', 'status'];

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('subcategories'); // Recursive relationship
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    } 

    // UPDATED: a product belongs to one category (products.category_id)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
