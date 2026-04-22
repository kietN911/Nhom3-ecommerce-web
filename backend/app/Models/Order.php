<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'total_price', 'status'];
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
