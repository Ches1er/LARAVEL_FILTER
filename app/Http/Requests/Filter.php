<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Filter extends FormRequest
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
            'min_price'=>'required|int', //|lt:max_price
            'max_price'=>'required|int',
        ];
    }
    public function messages()
    {
        return [
            'min_price.required' => 'A price is required',
            'max_price.required'  => 'A price is required',
            'min_price.int' => 'A price must be as integer',
            'max_price.int'  => 'A price must be as integer',
        ];
    }
}
