<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\DeliveryMethodController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCardTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatusOrderController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserPaymentCardController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::post('register',[AuthController::class,'register']);
Route::post('change-password',[AuthController::class,'changePassword']);

Route::get('user',[AuthController::class,'user'])->middleware('auth:sanctum');

Route::get('products/{product}/related',[ProductController::class,'related']);

Route::apiResources([
    'categories'=>CategoryController::class,
    'categories.products'=>CategoryProductController::class,
    'statuses'=>StatusController::class,
    'statuses.orders'=>StatusOrderController::class,
    'favorites'=>FavoriteController::class,
    'products'=>ProductController::class,
    'orders'=>OrderController::class,
    'delivery-methods'=>DeliveryMethodController::class,
    'payment-types'=>PaymentTypeController::class,
    'user-addresses'=>UserAddressController::class,
    'reviews'=>ReviewController::class,
    'products.reviews'=>ProductReviewController::class,
    'settings'=>SettingController::class,
    'user-settings'=>UserSettingController::class,
    'payment-card-types'=>PaymentCardTypeController::class,
    'user-payment-cards'=>UserPaymentCardController::class,
]);
