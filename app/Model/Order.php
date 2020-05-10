<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'subtotal_price', 'tax_price', 'total_price', 'shipping_price', 'shipped', 'shipping_address_id'
    ];

    protected $casts = [
        'created_at' => 'Y-m-d',
    ];
}
