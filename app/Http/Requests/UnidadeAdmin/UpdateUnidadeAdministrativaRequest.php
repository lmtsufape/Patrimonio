<?php

namespace App\Http\Requests\UnidadeAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadeAdministrativaRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'nome' => 'required|unique:unidades_administrativas|max:255',
            'codigo' => 'required|unique:unidades_administrativas|max:255',
            'unidade_admin_pai_id' => 'nullable|integer|exists:unidades_administrativas,id'
        ];
    }

    
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        return redirect()->back()->withErrors($errors)->withInput();
    }
    
}
