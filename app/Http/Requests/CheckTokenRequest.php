<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckTokenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'otp' => 'required|string|max:255',
        ];
    }
}
