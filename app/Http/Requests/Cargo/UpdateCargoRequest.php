<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCargoRequest extends FormRequest
{

    public function rules()
    {
        return [
            'nome' => 'required|unique:cargos|max:255'
        ];
    }
}
