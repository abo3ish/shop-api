<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use App\Events\OrderCreated;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderResource;
use Event;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{

    protected $cart;
    protected $user;

    public function __construct()
    {
        $this->cart = Cart::instance(auth()->id());
        $this->user = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->user->orders()->orderBy('created_at', 'desc')->get();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            if ($this->cart->count() == 0) {
                return collect([
                    "success" => false,
                    "message" => "you Cart is empty, please add items before checking out"
                ]);
            }
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal_price' => (float) $this->cart->subtotal(),
                'tax_price' => (float) $this->cart->tax(),
                'total_price' => (float) $this->cart->total(),
                'shipping_price' => 0,
                'shipped' => false,
                'shipping_address_id' => request()->shipping_address_id
            ]);

            foreach ($this->cart->content()->values()->all() as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->qty
                ]);
            }
            event(new OrderCreated());
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return collect([
                'success' => false,
                'message' => 'something went wrong, please try again'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function checkout()
    {
        if ($this->store() === true) {
            return response()->json([
                'success' => true,
                'message' => 'Congrates, Your Order is Done'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => $this->store()->get('message')
        ], 500);
    }
}
