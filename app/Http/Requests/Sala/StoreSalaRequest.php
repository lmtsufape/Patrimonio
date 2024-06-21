<?php

namespace App\Http\Requests\Sala;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreSalaRequest extends FormRequest
{

    public function rules()
    {
        return [
            'telefone' => 'required|regex:/^\(\d{2}\) \d{5}-\d{4}$/|unique:salas,nome',
            'nome' => 'required|unique:salas|max:255',
            'predio_id' => 'required|integer|exists:predios,id'
        ];
    }

    public function messages()
    {
        return [
            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.unique'   =>  'Telefone já cadastrado.',
            'nome.required' =>      'O campo nome é obrigatório',
        ];
    }

}
