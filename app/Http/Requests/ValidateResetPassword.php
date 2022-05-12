<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateResetPassword extends FormRequest
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
            'correo_usu'=>'required',
            'codigo_usu'=>'required',
            'contra_usu'=>'required|min:4|max:255',
            'contra_usu_verify' => 'required|min:4|max:255|same:contra_usu',
        ];
    }
}
