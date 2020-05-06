<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id', 'address', 'mobile_number', 'city', 'area', 'street', 'building', 'floor'
    ];
}
