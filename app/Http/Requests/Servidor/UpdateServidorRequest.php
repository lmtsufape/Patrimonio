<?php

namespace App\Http\Requests\Servidor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateServidorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => 'required|min:3',
            'matricula' => 'required|regex:/^[0-9]{9}$/',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        
        return redirect()->back()->withErrors($errors)->withInput();
    }
}
