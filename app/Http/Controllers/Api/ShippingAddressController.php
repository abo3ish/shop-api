<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\ShippingAddress;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ShippingAddresses\ShippingAddressResource;
use App\Http\Resources\ShippingAddresses\ShippingAddressCollection;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingAddresses = ShippingAddress::where('user_id', auth()->id())->get();
        return ShippingAddressResource::collection($shippingAddresses);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shippingAddress = ShippingAddress::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'city' => $request->city,
            'area' => $request->area,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
        ]);

        return response()->json([
            'success' => true,
            'data' => new ShippingAddressResource($shippingAddress)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingAddress $shippingAddress)
    {

        return response()->json([
            'success' => true,
            'data' => new ShippingAddressResource($shippingAddress)
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingAddress $shippingAddress)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        $shippingAddress->update([
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'city' => $request->city,
            'area' => $request->area,
            'street' => $request->street,
            'building' => $request->building,
            'floor' => $request->floor,
        ]);

        return response()->json([
            'success' => true,
            'data' => new ShippingAddressResource($shippingAddress)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingAddress $shippingAddress)
    {
        //
    }
}
