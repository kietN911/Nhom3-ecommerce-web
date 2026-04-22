<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'category',
        'category_id',
        'brand',
        'price',
        'original_price',
        'sale_price',
        'description',
        'short_description',
        'img',
        'stock_quantity',
        'tags',
        'is_featured',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'price' => 'integer',
            'original_price' => 'integer',
            'sale_price' => 'integer',
            'stock_quantity' => 'integer',
            'tags' => 'array',
            'is_featured' => 'integer',
            'status' => 'integer',
        ];
    }
}
