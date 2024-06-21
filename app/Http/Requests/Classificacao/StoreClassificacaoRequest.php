<?php

namespace App\Http\Requests\Classificacao;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassificacaoRequest extends FormRequest
{

    public function rules()
    {
        return [
            'nome' => 'required|unique:classificacoes|max:255',
            'codigo'    => 'required',
            'residual'  => 'required|numeric',
            'vida_util' => 'required|numeric',

        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'codigo.required' => 'o campo código é obrigatório.',
            'residual.required' => 'O campo residual é obrigatório.',
            'residual.numeric' => 'O campo residual é numérico.',
            'vida_util.required' => 'O campo vida útil é obrigatório.',
            'vida_util.numeric' => 'O campo vida útil é numérico.',
        ];
    }

}
