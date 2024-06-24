<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCargoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $cargoId = $this->route('cargo_id');

        return [
            'nome' => [
                'required',
                'max:255',
                Rule::unique('cargos')->ignore($cargoId),
            ],
        ];
    }
}
