<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServidorTemporarioRequest extends FormRequest {

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
            'pessoa.nome' => 'sometimes|required|string|max:200',
            'pessoa.sexo' => 'nullable|string|max:9',
            'pessoa.mae' => 'nullable|string|max:200',
            'pessoa.pai' => 'nullable|string|max:200',
            'pessoa.data_nascimento' => 'sometimes|required|date',
            'foto.base64' => 'nullable|string',
            'endereco.tipo_logradouro' => 'sometimes|required|string|max:50',
            'endereco.logradouro' => 'sometimes|required|string|max:200',
            'endereco.numero' => 'sometimes|required|integer',
            'endereco.bairro' => 'sometimes|required|string|max:100',
            'endereco.cid_id' => 'sometimes|required|exists:cidade,cid_id',
            'lotacao.unid_id' => 'sometimes|required|integer|exists:unidade,unid_id',
            'lotacao.lot_data_lotacao' => 'sometimes|required|date',
            'lotacao.lot_portaria' => 'nullable|string|max:100',
            'se_matricula' => 'sometimes|required|string|max:20',
        ];
    }
}
