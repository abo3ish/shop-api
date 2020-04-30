<?php

namespace App\Http\Controllers\Api;

use App\Model\Review;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reviews\ReviewResource;
use App\Http\Requests\Reviews\StoreReviewRequest;

class ReviewController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
        $review = Review::create([
            'text' => $request->text,
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'stars' => $request->stars
        ]);

        return response()->json([
            'data' => new ReviewResource($review),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReviewRequest $request, Product $product, Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            return response()->json([
                'error' => 'This is not Your review to Update'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $review->update($request->all());

        return response()->json([
            'data' => new ReviewResource($review),
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $review->delete();

        return response()->json([
            'data' => "Review Delete Succesffully",
        ], Response::HTTP_OK);
    }
}
