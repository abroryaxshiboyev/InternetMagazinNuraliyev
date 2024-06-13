<?php

namespace App\Http\Controllers;

use App\Models\PaymentCardType;
use App\Http\Requests\StorePaymentCardTypeRequest;
use App\Http\Requests\UpdatePaymentCardTypeRequest;

class PaymentCardTypeController extends Controller
{
    public function index()
    {
        return $this->response(PaymentCardType::all());
    }

    public function store(StorePaymentCardTypeRequest $request)
    {
        //
    }

    public function show(PaymentCardType $paymentCardType)
    {
        //
    }

    public function update(UpdatePaymentCardTypeRequest $request, PaymentCardType $paymentCardType)
    {
        //
    }

    public function destroy(PaymentCardType $paymentCardType)
    {
        //
    }
}
