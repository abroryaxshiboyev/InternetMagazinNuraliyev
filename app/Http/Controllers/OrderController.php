<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return Auth::user()->orders;
    }


    public function store(StoreOrderRequest $request)
    {
        $sum = 0;

        $products = Product::query()->limit(2)->get();
        $address=UserAddress::find($request->address_id);

        Auth::user()->orders()->create([
            'comment' => $request->comment,
            'delivery_method_id' => $request->delivery_method_id,
            'payment_type_id' => $request->payment_type_id,
            'address' => $address,
            'sum' => $sum,
            'products' => $products,
        ]);
        return 'success';
    }


    public function show(Order $order)
    {
        return new OrderResource($order);
    }


    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
