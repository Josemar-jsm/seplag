<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnidadeRequest extends FormRequest {

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
            'unid_nome' => 'required|string|max:200',
            'unid_sigla' => 'required|string|max:20',
            'endereco.tipo_logradouro' => 'required|string|max:50',
            'endereco.logradouro' => 'required|string|max:150',
            'endereco.numero' => 'required|string|max:10',
            'endereco.bairro' => 'required|string|max:100',
            'endereco.cid_id' => 'required|integer|exists:cidade,cid_id'
        ];
    }
}
