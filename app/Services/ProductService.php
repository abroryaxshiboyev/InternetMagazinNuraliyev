<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductService extends Service
{
    public function checkForStock($requestProducts,$sum,array $products,array $notFoundProducts)
    {
        foreach ($requestProducts as $requestProduct) {
            $product = Product::with('stocks')->findOrFail($requestProduct['product_id']);
            $product->quantity = $requestProduct['quantity'];

            if (
                $product->stocks()->find($requestProduct['stock_id']) &&
                $product->stocks()->find($requestProduct['stock_id'])->quantity >= $requestProduct['quantity']
            ) {
                $productWithStock = $product->withStock($requestProduct['stock_id']);
                $productResource = (new ProductResource($productWithStock))->resolve();

                $sum += ($productResource['discounted_price'] ?? $productResource['price']) * $requestProduct['quantity'];
                $products[] = $productResource;
            } else {
                $requestProduct['we_have'] = $product->stocks()->find($requestProduct['stock_id'])->quantity;
                $notFoundProducts[] = $requestProduct;
            }
        }

        return array($sum,$products,$notFoundProducts);
    }
}