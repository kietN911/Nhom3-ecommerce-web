<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; // Only created_at exists

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
