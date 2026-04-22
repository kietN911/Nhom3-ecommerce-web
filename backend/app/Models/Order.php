<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'fullname',
        'phone',
        'email',
        'address',
        'total_money',
        'shipping_fee',
        'discount_amount',
        'note',
        'shipping_method',
        'payment_method',
        'payment_status',
        'shipping_status',
        'status',
        'order_date',
        'confirmed_at',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'total_money' => 'integer',
            'shipping_fee' => 'integer',
            'discount_amount' => 'integer',
            'status' => 'integer',
            'order_date' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }
}
