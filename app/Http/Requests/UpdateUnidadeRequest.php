<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadeRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unid_nome' => 'sometimes|string|max:200',
            'unid_sigla' => 'sometimes|string|max:20',
            'endereco.tipo_logradouro' => 'sometimes|string|max:50',
            'endereco.logradouro' => 'sometimes|string|max:150',
            'endereco.numero' => 'sometimes|string|max:10',
            'endereco.bairro' => 'sometimes|string|max:100',
            'endereco.cid_id' => 'sometimes|integer|exists:cidade,cid_id'
        ];
    }
}
