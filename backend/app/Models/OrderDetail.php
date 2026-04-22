<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'product_sku',
        'product_image',
        'quantity',
        'price',
        'subtotal',
        'note',
    ];

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'quantity' => 'integer',
            'price' => 'integer',
            'subtotal' => 'integer',
        ];
    }
}
