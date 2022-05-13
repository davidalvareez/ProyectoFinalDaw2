<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProfeOAuth extends FormRequest
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
            'fecha_nac_prof'=>'required|date',
            'contra_profe'=>'required|min:4|max:255',
            'contra_profe_verify' => 'required|min:4|max:255|same:contra_profe',
            'curriculum_profe2' => 'mimes:pdf',
        ];
    }
}
