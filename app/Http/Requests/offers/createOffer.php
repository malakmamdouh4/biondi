<?php

namespace App\Http\Requests\offers;

use Illuminate\Foundation\Http\FormRequest;

class CreateOffer extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'discountRate' => 'required_without:discountAmount',
            'discountAmount' => 'required_without:discountRate',
        ];
    }
}
  