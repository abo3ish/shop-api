<?php

namespace App\Http\Controllers\Api;

// use App\Model\Cart;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\Carts\CartResource;
use App\Http\Resources\Carts\CartCollection;
use Symfony\Component\HttpFoundation\Response;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;

class CartController extends Controller
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Cart::instance(auth()->id());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->cart->restore(auth()->id());
        return response()->json([
            'success' => true,
            'data' => new CartCollection($this->cart->content()->values()->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = Product::find($request->product_id);
        $this->cart->add(
            $product,
            1
        );

        $this->cart->store(auth()->id());

        return response()->json([
            'success' => true,
            'data' => CartResource::collection($this->cart->content()->values()->all())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            if ($request->quantity == 0) {
                $this->cart->remove($request->rowId);
            } else {
                $this->cart->update($request->rowId,
                    $request->quantity
                );
            }

            $this->cart->store(auth()->id());

            return response()->json([
                'success' => true,
                'data' => CartResource::collection($this->cart->content()->values()->all())
            ]);
        } catch (InvalidRowIDException $e) {
            return response()->json([
                'success' => false,
                'message' => "Sorry, This item is not found"
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Sorry, Something went wrong, please try again"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this->cart->destroy();
    }
}
