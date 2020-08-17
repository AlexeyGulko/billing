<?php

namespace App\Http\Requests;

use App\Rules\Luhn;
use Illuminate\Foundation\Http\FormRequest;

class PaymentResolveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner'         => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'number'        => ['required', new Luhn()],
            'expiration'    => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv'           => 'required|regex:/^\d{3}$/',
        ];
    }
}
