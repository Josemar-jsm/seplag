<?php

namespace App\Repositories;

use App\Models\Endereco;
use App\Models\Unidade;
use App\Models\UnidadeEndereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnidadeRepository {

    public function listarTodos()
    {
        return Unidade::with('enderecos.cidade')->paginate();
    }

    public function buscarPorId($id): Unidade
    {
        return Unidade::with('enderecos.cidade')->findOrFail($id);
    }

    public function criar(array $data): Unidade
    {
        return DB::transaction(function () use ($data) {
                    $unidade = Unidade::create([
                        'unid_nome' => $data['unid_nome'],
                        'unid_sigla' => $data['unid_sigla'],
                    ]);

                    $endereco = Endereco::create([
                        'end_tipo_logradouro' => $data['endereco']['tipo_logradouro'],
                        'end_logradouro' => $data['endereco']['logradouro'],
                        'end_numero' => $data['endereco']['numero'],
                        'end_bairro' => $data['endereco']['bairro'],
                        'cid_id' => $data['endereco']['cid_id']
                    ]);

                    UnidadeEndereco::create([
                        'unid_id' => $unidade->unid_id,
                        'end_id' => $endereco->end_id
                    ]);

                    return $unidade->load('enderecos.cidade');
                });
    }

    public function atualizar($id, array $data): Unidade
    {
        return DB::transaction(function () use ($id, $data) {
                    $unidade = Unidade::with('enderecos')->findOrFail($id);

                    $unidade->update([
                        'unid_nome' => $data['unid_nome'] ?? $unidade->unid_nome,
                        'unid_sigla' => $data['unid_sigla'] ?? $unidade->unid_sigla,
                    ]);

                    if (isset($data['endereco'])) {
                        $endereco = $unidade->enderecos->first();
                        if ($endereco) {
                            $endereco->update([
                                'end_tipo_logradouro' => $data['endereco']['tipo_logradouro'] ?? $endereco->end_tipo_logradouro,
                                'end_logradouro' => $data['endereco']['logradouro'] ?? $endereco->end_logradouro,
                                'end_numero' => $data['endereco']['numero'] ?? $endereco->end_numero,
                                'end_bairro' => $data['endereco']['bairro'] ?? $endereco->end_bairro,
                                'cid_id' => $data['endereco']['cid_id'] ?? $endereco->cid_id
                            ]);
                        }
                    }

                    return $unidade->load('enderecos.cidade');
                });
    }

    public function deletar($id): void
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();
    }
}
