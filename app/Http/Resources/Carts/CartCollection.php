<?php

namespace App\Http\Resources\Carts;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'total' => $this->getSubTotal(),
            'items' => CartResource::collection($this->collection)
        ];
    }

    public function getSubTotal()
    {
        return Cart::instance(auth()->id())->subtotal();
    }
}
