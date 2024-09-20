<?php

namespace App\Http\Requests\Servidor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreServidorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cpf' => 'required|regex:/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/',
            'password' => 'required|string|min:8',
            'matricula' => 'required|numeric|digits:9|unique:users',
            'cargo_id' => 'required',
            'role_id'   => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'matricula.min' => 'O número da matrícula deve ser no mínimo de 9.',
            'matricula.numeric' => 'A matricula precisa ser numerica'
        ];
    }

}
