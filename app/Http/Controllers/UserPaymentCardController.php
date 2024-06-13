<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentCard;
use App\Http\Requests\StoreUserPaymentCardRequest;
use App\Http\Requests\UpdateUserPaymentCardRequest;
use App\Http\Resources\UserPaymentCardResource;

class UserPaymentCardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        return $this->response(UserPaymentCardResource::collection(auth()->user()->paymentCards));
    }

    public function store(StoreUserPaymentCardRequest $request)
    {
        $card=auth()->user()->paymentCards()->create([
            'name' => encrypt($request->name),
            'number' => encrypt($request->numbe),
            'exp_date' => encrypt($request->exp_date),
            'holder_name' => encrypt($request->holder_name),
            'payment_card_type_id' => $request->payment_card_type_id,
            'last_four_numbers' => encrypt(substr($request->number,-4)),
        ]);

        return $this->success('user payment card created successfully');
    }

    public function show(UserPaymentCard $userPaymentCard)
    {
        //
    }

    public function destroy(UserPaymentCard $userPaymentCard)
    {
        //
    }
}
