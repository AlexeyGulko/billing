<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
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
            'value'     => ['required', 'regex:/^\d{1,8}($|\.\d{0,2}$)/',],
            'recipient' => 'required',
            'notificationURL' => 'nullable|url',
        ];
    }
}
