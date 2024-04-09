<?php

namespace App\Http\Requests\Patrimonio;

use Illuminate\Foundation\Http\FormRequest;

class FilterPatrimonioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'busca' => 'sometimes|required|string',
            'predio_id' => 'sometimes|required|integer|exists:predios,id',
            'servidor_id' => 'sometimes|required|integer|exists:servidores,id',
            'situacao_id' => 'sometimes|required|integer|exists:situacoes,id',
            'origem_id' => 'sometimes|required|integer|exists:origens,id',
            'setor_id' => 'sometimes|required|integer|exists:setores,id',
            'classificacao_id' => 'sometimes|required|integer|exists:classificacoes,id',
        ];
    }
}
