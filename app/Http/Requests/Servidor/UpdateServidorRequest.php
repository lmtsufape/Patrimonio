<?php

namespace App\Http\Requests\Servidor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateServidorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cpf' => 'required|regex:/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/',
            'matricula' => 'required|numeric|digits:9',  Rule::unique('users')->ignore($this->route('id')),
            'cargo_id' => 'required',
            'role_id'   => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'matricula.digits_between' => 'O número da matrícula deve ser no mínimo de 9.',
            'matricula.numeric' => 'A matrícula precisa ser numerica'
        ];
    }

}
