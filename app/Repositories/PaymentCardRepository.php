<?php

namespace App\Repositories;

use App\Http\Requests\StoreUserPaymentCardRequest;

class PaymentCardRepository extends Repository 
{
    public function savePaymentCard(StoreUserPaymentCardRequest $request):void
    {
        auth()->user()->paymentCards()->create([
            'name' => encrypt($request->name),
            'number' => encrypt($request->numbe),
            'exp_date' => encrypt($request->exp_date),
            'holder_name' => encrypt($request->holder_name),
            'payment_card_type_id' => $request->payment_card_type_id,
            'last_four_numbers' => encrypt(substr($request->number,-4)),
        ]);
    }
}
