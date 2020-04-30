<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
            'name' => $this->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'link' => [
                'href' => route('products.show', $this->id),
            ],
        ];
    }
}
