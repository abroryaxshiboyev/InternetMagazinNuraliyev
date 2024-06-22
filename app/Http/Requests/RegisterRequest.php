<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'nullable',
            'email'=>'required|email:rfc,dns|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'password'=>'required|min:8',
            'password_confirmation'=>'required|same:password',
            'photo'=>'nullable|file|mimes:jpg,png,bmp|max:1000'
        ];
    }
}
