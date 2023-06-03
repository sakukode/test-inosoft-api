<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'product' => 'required|array',
            'product.id' => 'required',
            'quantity' => 'required|numeric',
            'customer' => 'required|array',
            'customer.name' => 'required|string',
            'customer.phone' => 'nullable',
            'customer.address' => 'nullable'
        ];
    }
}
