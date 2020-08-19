<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PaymentIndexRequest extends FormRequest
{
    protected $redirect = '/payments';

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
            'from'  => 'date',
            'to'    => 'date'
        ];
    }

    protected function prepareForValidation()
    {
        $this->from = $this->dateToCarbon($this->from);
        $this->to = $this->dateToCarbon($this->to);
    }

    protected function dateToCarbon($date)
    {
        return strtotime($date)
            ? Carbon::parse($date)
            : null;
    }
}
