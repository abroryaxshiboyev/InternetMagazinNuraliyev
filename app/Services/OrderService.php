<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Repositories\OrderRepository;
use App\Repositories\StockRepository;

class OrderService extends Service
{
    protected StockRepository $stockRepository;
    protected OrderRepository $orderRepository;

    public function __construct()
    {
        $this->stockRepository=app(StockRepository::class);
        $this->orderRepository=app(OrderRepository::class);
    }

    public function saveOrder($sum,$deliveryMethod,StoreOrderRequest $request,$address,array $products)
    {
        $sum += $deliveryMethod->sum;
        $order = $this->orderRepository->createOrder($request, $sum, $address, $products);
        
        if ($order) {
            $this->stockRepository->subtractFromStock($products);
        }

        return $order;
    }
}