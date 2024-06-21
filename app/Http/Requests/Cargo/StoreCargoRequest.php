<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
{

    public function rules()
    {
        return [
            'nome' => 'required|unique:cargos|max:255'
        ];
    }

    public function messages(){
        return [
            'nome.required' =>  'O campo nome é obrigatório.',
            'nome.unique'   =>  'O campo nome precisa ser único.',
            'nome.max'      =>  'O campo nome não pode ter mais de 244 caracteres.'
        ];
    }
}
