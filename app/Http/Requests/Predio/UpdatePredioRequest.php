<?php

namespace App\Http\Requests\Predio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdatePredioRequest extends FormRequest
{
    public function rules()
    {
        $predioId = $this->route('id');

        return [
            'nome' => ['required', 'max:255', Rule::unique('predios')->ignore($predioId)],
        ];
    }

}
