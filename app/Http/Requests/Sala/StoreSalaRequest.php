<?php

namespace App\Http\Requests\Sala;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalaRequest extends FormRequest
{

    public function rules()
    {
        $salaId = $this->route('sala_id');

        return [
            'telefone' => 'required|regex:/^\(\d{2}\) \d{5}-\d{4}$/|unique:salas,telefone',
            'nome' => ['required',
                        'max:255',
                        Rule::unique('salas')->where(function ($query) use ($salaId) {
                            return $query->where('predio_id', $this->predio_id)->where('id', '!=', $salaId);
            }),],
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
