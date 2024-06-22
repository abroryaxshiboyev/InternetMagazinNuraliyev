<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
    }
    public function index()
    {
        $products = Product::cursorPaginate(25);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product=Product::create($request->toArray());

        return $this->success(data:new ProductResource($product));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        Gate::authorize('product:delete');

        Storage::delete($product->photos()->pluck('path')->toArray());

        $product->photos()->delete();

        $product->delete();

        return $this->success('Product deleted successfully');
    }

    public function related(Product $product)
    {
        return $this->response(
            Product::query()
                ->where('category_id', $product->category_id)
                ->limit(20)
                ->get()
        );
    }
}
