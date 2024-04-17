<?php

namespace App\Http\Requests\Servidor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreServidorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'cpf' => 'required|regex:/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/',
            'matricula' => 'required|regex:/^[0-9]{9}$/',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        return redirect()->back()->withErrors($errors)->withInput();
    }

}
