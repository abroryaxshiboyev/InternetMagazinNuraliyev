<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\DeliveryMethodController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCardTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatusOrderController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPaymentCardController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\UserSettingController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;





Route::get('products/{product}/related',[ProductController::class,'related']);
Route::post('permissions/assign',[PermissionController::class,'assign']);
Route::post('roles/assign',[RoleController::class,'assign']);


Route::get('test',function(){

    $order=Order::find(1);
    $order->update(['status_id' => 4]);

    dd($order->status_id);
});

Route::apiResources([
    'users'=>UserController::class,
    'roles'=>RoleController::class,
    'orders'=>OrderController::class,
    'photos'=>PhotoController::class,
    'reviews'=>ReviewController::class,
    'statuses'=>StatusController::class,
    'products'=>ProductController::class,
    'settings'=>SettingController::class,
    'discounts'=>DiscountController::class,
    'favorites'=>FavoriteController::class,
    'categories'=>CategoryController::class,
    'users.photos'=>UserPhotoController::class,
    'permissions'=>PermissionController::class,
    'user-settings'=>UserSettingController::class,
    'payment-types'=>PaymentTypeController::class,
    'user-addresses'=>UserAddressController::class,
    'statuses.orders'=>StatusOrderController::class,
    'products.photos'=>ProductPhotoController::class,
    'products.reviews'=>ProductReviewController::class,
    'delivery-methods'=>DeliveryMethodController::class,
    'payment-card-types'=>PaymentCardTypeController::class,
    'user-payment-cards'=>UserPaymentCardController::class,
    'categories.products'=>CategoryProductController::class,
]);
