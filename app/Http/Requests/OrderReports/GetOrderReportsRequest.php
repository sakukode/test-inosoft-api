<?php

namespace App\Http\Requests\OrderReports;

use Illuminate\Foundation\Http\FormRequest;

class GetOrderReportsRequest extends FormRequest
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
            'start_date' => 'nullable|date:Y-m-d',
            'end_date' => 'nullable|date:Y-m-d',
        ];
    }
}
