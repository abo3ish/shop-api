<?php

namespace App\Http\Controllers\Api;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Exceptions\ProductNotBelongsToUser;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        // $this->verifiyProductUser($product);

        $product = new Product;
        $request['detail'] = $request->description;
        unset($product['description']);
        $product = Product::create($request->all());

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->verifiyProductUser($product);

        $request['detail'] = $request->description;
        unset($request['description']);

        $product->update($request->all());

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->verifiyProductUser($product);

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully'
        ], Response::HTTP_OK);
    }

    protected function verifiyProductUser($product)
    {
        if (auth()->id() !== $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }
}
