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
            'nome.required' => 'dsfdf',
            'codigo.required' => 'dfsf',
            'residual.numeric' => 'ta errado',
            'vida_util.numeric' => 'ta errado',
        ];
    }

}
