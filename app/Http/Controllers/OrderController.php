<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Stock;
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

        // $products = Product::query()->limit(2)->get();

        $notFoundProducts = [];
        $address = UserAddress::find($request->address_id);

        foreach ($request->products as $requestProduct) {
            $product = Product::with('stocks')->findOrFail($requestProduct['product_id']);

            $product->quantity = $requestProduct['quantity'];

            if (
                $product->stocks()->find($requestProduct['stock_id']) &&
                $product->stocks()->find($requestProduct['stock_id'])->quantity >= $requestProduct['quantity']
            ) {
                $productWithStock = $product->withStock($requestProduct['stock_id']);
                $productResource = (new ProductResource($productWithStock));


                $sum += $productResource['price'] * $requestProduct['quantity'];
                $products[] = $productResource->resolve();
            } else {
                $requestProduct['we_have']=$product->stocks()->find($requestProduct['stock_id'])->quantity;
                $notFoundProducts[] = $requestProduct;
            }
        }


        if ($notFoundProducts === [] && $products !==[] && $sum!==0) {
            // TODO add status of order
            $order = auth()->user()->orders()->create([
                'comment' => $request->comment,
                'delivery_method_id' => $request->delivery_method_id,
                'payment_type_id' => $request->payment_type_id,
                'sum' => $sum,
                'status_id'=>in_array($request['payment_type_id'],[1,2])?1:10,
                'address' => $address,
                'products' => $products,
            ]);

            if ($order) {
                foreach ($products as $product) {
                    $stock = Stock::find($product['inventory'][0]['id']);
                    $stock->quantity -= $product['order_quantity'];
                    $stock->save();
                }
            }
            return 'success';
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'some products not found or does not have in inventory',
                'not_found_products' =>$notFoundProducts
            ]);
        }
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
