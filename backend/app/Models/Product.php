<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'price',
        'description',
        'img',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'status' => 'integer',
        ];
    }
}
