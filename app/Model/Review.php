<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['text', 'stars', 'user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
