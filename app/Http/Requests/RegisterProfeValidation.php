<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProfeValidation extends FormRequest
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
            'nombre_profe'=>'required|string|max:255|',
            'apellido_profe'=>'required|string|max:255|',
            'nick_usu'=>'required|string|max:255|unique:tbl_usuario',
            'fecha_nac_profe'=>'required|date',
            'correo_usu'=>'required|string|max:255|unique:tbl_usuario',
            'contra_profe'=>'required|min:4|max:255',
            'contra_profe_verify' => 'required|min:4|max:255|same:contra_profe',
            'img_avatar_usu'=>'mimes:jpg,png,jpeg,webp,svg',
            'img_avatar_usu2'=>'mimes:jpg,png,jpeg,webp,svg',
            'curriculum_profe2'=>'mimes:pdf',
        ];
    }
}
