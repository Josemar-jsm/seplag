<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServidorTemporarioRequest extends FormRequest {

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
            'pessoa.nome' => 'required|string|max:200',
            'pessoa.sexo' => 'nullable|string|max:9',
            'pessoa.mae' => 'nullable|string|max:200',
            'pessoa.pai' => 'nullable|string|max:200',
            'pessoa.data_nascimento' => 'required|date',
            'foto.base64' => 'nullable|string',
            'endereco.tipo_logradouro' => 'required|string|max:50',
            'endereco.logradouro' => 'required|string|max:200',
            'endereco.numero' => 'required|integer',
            'endereco.bairro' => 'required|string|max:100',
            'endereco.cid_id' => 'required|exists:cidade,cid_id',
            'lotacao.unid_id' => 'required|integer|exists:unidade,unid_id',
            'lotacao.lot_data_lotacao' => 'required|date',
            'lotacao.lot_portaria' => 'nullable|string|max:100',
            'se_matricula' => 'required|string|max:20',
        ];
    }
}
