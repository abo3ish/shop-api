<?php

namespace App\Http\Resources\Orders;

use App\Model\ShippingAddress;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShippingAddresses\ShippingAddressResource;

class OrderResource extends JsonResource
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
            'subtotal_price' => $this->subtotal_price,
            'tax_price' => $this->tax_price,
            'total_price' => $this->total_price,
            'shipping_price' => $this->shipping_price,
            'shipped' => (bool) $this->shipped,
            'shipping_address' => new ShippingAddressResource(ShippingAddress::find($this->shipping_address_id)),
            'created_at' => $this->created_at,
        ];
    }
}
