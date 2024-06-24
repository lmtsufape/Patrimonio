<?php

namespace App\Http\Requests\UnidadeAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnidadeAdministrativaRequest extends FormRequest
{

    public function rules()
    {
        $unidadeAdm = $this->route('id');

        return [
            'nome' => ['required', Rule::unique('unidades_administrativas')->ignore($unidadeAdm), 'max:255'],
            'codigo' => ['required', Rule::unique('unidades_administrativas')->ignore($unidadeAdm), 'max:255'],
            'unidade_admin_pai_id' => ['nullable', 'integer', 'exists:unidades_administrativas,id'],
            'predio_id' => ['required', 'exists:predios,id'],

        ];
    }

    public function messages()
    {
        return [
            'nome.required'     =>      'O campo nome é obrigatório.',
            'codigo.required'   =>      'O campo código é obrigatório.',
            'predio_id.required'    =>  'O campo de prédio é obrigatório.'
        ];
    }
}
