<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Product $product)
    {
        // return $product->reviews;

        return response()->json([
            'overall_rating'=>$product->reviews()->avg('rating'),
            'reviews_count'=>$product->reviews()->count(),
            'reviews'=>ReviewResource::collection($product->reviews()->paginate(10))
        ]);
    }

    public function store(Product $product,StoreReviewRequest $request)
    {
        $product->reviews()->create([
            'user_id'=>auth()->id(),
            'rating'=>$request->rating,
            'body'=>$request->body
        ]);

        return response()->json(['success'=>true,'message'=>'review created successfully']);
    }
}
