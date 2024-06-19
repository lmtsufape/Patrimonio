<?php

namespace App\Http\Requests\Movimento;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovimentoRequest extends FormRequest
{

    public function rules()
    {
        return [
            'tipo' => 'required|integer|',
            'patrimonios_id'   => 'required',
            'user_destino_id' => 'required|integer|exists:users,id',
            'observacao' => 'required_if:tipo,3','string','max:255',
            'user_origem_id' => 'integer|exists:users,id',
            'data_movimento' => 'date'
        ];
    }

    public function messages(){
        return [
            'observacao.required_if' => 'Precia da observação'
        ];
    }
}
