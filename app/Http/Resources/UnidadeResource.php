<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @author josemarsilva
 */
class UnidadeResource extends JsonResource {

    public function toArray($request): array
    {
        $endereco = $this->enderecos->first();

        return [
            'id' => $this->unid_id,
            'nome' => $this->unid_nome,
            'sigla' => $this->unid_sigla,
            'endereco' => [
                'tipo_logradouro' => optional($endereco)->end_tipo_logradouro,
                'logradouro' => optional($endereco)->end_logradouro,
                'numero' => optional($endereco)->end_numero,
                'bairro' => optional($endereco)->end_bairro,
                'cidade' => optional(optional($endereco)->cidade)->cid_nome,
                'uf' => optional(optional($endereco)->cidade)->cid_uf,
            ]
        ];
    }
}
