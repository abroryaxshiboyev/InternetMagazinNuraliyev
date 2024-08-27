<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\DeliveryMethod;
use App\Models\Product;
use App\Models\UserAddress;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $orderService,
        protected ProductService $productService,
    ) {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $userOrders=auth()->user()->orders();
        if (request()->has('status_id')) {
            $response=$userOrders->where('status_id', request('status_id'));
        }
        return $this->response(OrderResource::collection($response->paginate(10)));
    }


    public function store(StoreOrderRequest $request)
    {
        $sum = 0;
        $products = [];
        $notFoundProducts = [];
        $address = UserAddress::find($request->address_id);
        $deliveryMethod = DeliveryMethod::findOrFail($request->delivery_method_id);

        list($sum,$products,$notFoundProducts)=$this->productService->checkForStock($request['products'],$sum,$products,$notFoundProducts);


        if ($notFoundProducts === [] && $products !== [] && $sum !== 0) {
           $order=$this->orderService->saveOrder($sum,$deliveryMethod,$request,$address,$products);

            return $this->success('order created', $order);
        }


        return $this->error(
            'some products not found or does not have in inventory',
            ['not_found_products' => $notFoundProducts]
        );
    }


    public function show(Order $order): JsonResponse
    {
        return $this->response(new OrderResource($order));
    }


    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return 1;
    }
}
