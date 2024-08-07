<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class uploadFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'lastname' => 'required',
            'id' => 'required',
            'file' => 'required|file|mimes:png,docx,jpeg|max:6048',
        ];
    }
}
