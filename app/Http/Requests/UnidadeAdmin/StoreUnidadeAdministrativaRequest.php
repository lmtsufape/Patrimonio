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
            'unidade_admin_pai_id' => 'nullable|integer|exists:unidades_administrativas,id',
            'predio_id' => 'required|exists:predios,id',
        ];
    }


    public function messages(){
        return [
            'nome.required'     =>  'O campo nome é obrigatório.',
            'codigo.required'    =>  'O campo codigo é obrigatório.',
            'unidade_admin_pai_id.integer'   =>  'O campo unidade é um inteiro.',
            'predio_id'  =>  'O campo prédio é obrigatório.',
        ];
    }

}
