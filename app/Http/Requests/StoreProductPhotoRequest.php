<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductPhotoRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return request()->user()->can('product:create');
    }


    public function rules(): array
    {
        return [
            'photos.*'=>'required|file|mimes:png,jpg|max:10000'
        ];
    }
}
