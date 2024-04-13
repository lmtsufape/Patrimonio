<?php

namespace App\Http\Requests\UnidadeAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnidadeAdministrativaRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'nome' => 'required|unique:unidades_administrativas|max:255',
            'codigo' => 'required|unique:unidades_administrativas|max:255',
            'unidades_admin_pai_id' => 'nullable|integer|exists:unidades_administrativas,id'
        ];
    }

    
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        return redirect()->back()->withErrors($errors)->withInput();
    }
    
}
