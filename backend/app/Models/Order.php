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
        'address',
        'total_money',
        'note',
        'shipping_method',
        'status',
        'order_date',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'total_money' => 'integer',
            'status' => 'integer',
            'order_date' => 'datetime',
        ];
    }
}
