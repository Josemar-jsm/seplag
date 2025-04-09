<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 *
 * @author josemarsilva
 */
class ServidorTemporarioResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'id' => $this->pes_id,
            'se_matricula' => $this->se_matricula,
            'pessoa' => [
                'nome' => $this->pessoa->pes_nome,
                'data_nascimento' => $this->pessoa->pes_data_nascimento,
                'sexo' => $this->pessoa->pes_sexo,
                'mae' => $this->pessoa->pes_mae,
                'pai' => $this->pessoa->pes_pai,
                'foto' => [
                    'url' => filled($this->pessoa->foto?->fp_base64) ? Storage::disk('s3')->url($this->pessoa->foto->fp_base64) : null,
                    'data' => optional($this->pessoa->foto)->fp_data,
                    'bucket' => optional($this->pessoa->foto)->fp_bucket,
                    'hash' => optional($this->pessoa->foto)->fp_hash,
                ],
                'enderecos' => $this->pessoa->enderecos->map(function ($e) {
                    return [
                        'tipo_logradouro' => optional($e->endereco)->end_tipo_logradouro,
                        'logradouro' => optional($e->endereco)->end_logradouro,
                        'numero' => optional($e->endereco)->end_numero,
                        'bairro' => optional($e->endereco)->end_bairro,
                        'cidade' => optional(optional($e->endereco)->cidade)->cid_nome,
                        'uf' => optional(optional($e->endereco)->cidade)->cid_uf
                    ];
                })
            ],
            'lotacoes' => $this->pessoa->lotacoes->map(function ($l) {
                return [
                    'unidade' => optional($l->unidade)->unid_nome,
                    'data_lotacao' => $l->lot_data_lotacao,
                    'data_remocao' => $l->lot_data_remocao,
                    'portaria' => $l->lot_portaria
                ];
            })
        ];
    }
}
