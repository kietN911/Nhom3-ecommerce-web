<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_name',
        'receiver_phone',
        'label',
        'address_line',
        'ward',
        'district',
        'city',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'is_default' => 'integer',
        ];
    }
}
