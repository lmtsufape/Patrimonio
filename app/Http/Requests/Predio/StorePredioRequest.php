<?php

namespace App\Http\Requests\Predio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StorePredioRequest extends FormRequest
{
    public function rules()
    {
        return [

            'nome' => 'required|unique:predios|max:255'

        ];

    }

    public function messages()
    {
        return [
            'nome.required'     =>      'O campo nome é obrigatório.',
            'nome.max'          =>      'O campo nome não pode ter mais de 244 caracteres.'
        ];
    }

}
