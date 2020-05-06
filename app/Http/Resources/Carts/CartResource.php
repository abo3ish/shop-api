<?php

namespace App\Http\Resources\Carts;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rowId' => $this->rowId,
            'qty' => $this->qty,
            'price' => $this->price,
            'image' => $this->model->image,
            'discount' => $this->discount ?? 0,
            'subtotal' => $this->subtotal,
        ];
    }

    public function getSubTotal()
    {
        return Cart::instance(auth()->id())->subtotal();
    }
}
