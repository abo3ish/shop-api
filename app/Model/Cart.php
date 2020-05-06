<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart as ShoppingCart;

class Cart extends Model
{
    protected $table = 'shoppingcart';

    public function add($product)
    {
        ShoppingCart::add($product, 1);
    }
}
