<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'desc' => $this->detail,
            'image' => $this->image,
            'categoryName' => $this->category->name,
            'price' => $this->price,
            'discount' => $this->discount,
            'totalPrice' => round($this->price - ($this->discount / 100) * $this->price, 2),
            'stock' => $this->stock == 0 ? 'out of stock' : $this->stock,
            'reviewsCount' => count($this->reviews),
            'rating' => count($this->reviews) == 0 ? 0 : round($this->reviews->sum('stars') / $this->reviews->count(), 2),
            // 'reviews' => [
            //     'href' => route('reviews.index', $this->id),
            // ]
        ];
    }
}
