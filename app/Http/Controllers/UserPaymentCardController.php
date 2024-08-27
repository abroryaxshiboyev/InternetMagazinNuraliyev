<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentCard;
use App\Http\Requests\StoreUserPaymentCardRequest;
use App\Http\Requests\UpdateUserPaymentCardRequest;
use App\Http\Resources\UserPaymentCardResource;
use App\Repositories\PaymentCardRepository;

class UserPaymentCardController extends Controller
{
    protected PaymentCardRepository $paymentCardRepository;
    public function __construct()
    {
        $this->paymentCardRepository=app(PaymentCardRepository::class);
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        return $this->response(UserPaymentCardResource::collection(auth()->user()->paymentCards));
    }

    public function store(StoreUserPaymentCardRequest $request)
    {
        $this->paymentCardRepository->savePaymentCard($request);
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
