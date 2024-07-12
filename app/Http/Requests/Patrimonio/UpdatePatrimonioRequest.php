<?php

namespace App\Http\Requests\Patrimonio;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatrimonioRequest extends FormRequest
{

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'nota_fiscal' => 'nullable|string|max:255',
            'descricao' => 'required|string|max:255',
            'data_incorporacao' => 'required|date',
            'user_id' => 'required|integer|exists:users,id',
            'unidade_admin_id' => 'required|integer|exists:unidades_administrativas,id',
            'classificacao' => 'required|integer|exists:classificacoes,id',
            'origem_id' => 'required|integer|exists:origens,id',
            'sala_id' => 'required|integer|exists:salas,id',
            'situacao_id' => 'required|integer|exists:situacoes,id',
            'processo_licitacao' => 'required|integer'

        ];
    }

}
