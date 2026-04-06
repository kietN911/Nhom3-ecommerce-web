<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    public $timestamps = false; // Based on DESCRIBE output

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
