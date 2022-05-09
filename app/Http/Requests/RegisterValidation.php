<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
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
            'nombre_usu'=>'required|string|max:255|',
            'apellido_usu'=>'required|string|max:255|',
            'nick_usu'=>'required|string|max:255|unique:tbl_usuario',
            'fecha_nac_usu'=>'required|date',
            'correo_usu'=>'required|string|max:255|unique:tbl_usuario',
            'contra_usu'=>'required|min:4|max:255',
            'contra_usu_verify' => 'required|min:4|max:255|same:contra_usu',
        ];
    }
}
