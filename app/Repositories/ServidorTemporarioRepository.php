<?php

namespace App\Repositories;

use App\Models\Pessoa;
use App\Models\FotoPessoa;
use App\Models\Lotacao;
use App\Models\Endereco;
use App\Models\PessoaEndereco;
use App\Models\ServidorTemporario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Description of ServidorEfetivoRepository
 *
 * @author josemarsilva
 */

class ServidorTemporarioRepository
{
    public function criarServidorTemporario(array $data)
    {
        return DB::transaction(function () use ($data) {
            $pessoa = Pessoa::create([
                'pes_nome' => $data['pessoa']['nome'],
                'pes_data_nascimento' => $data['pessoa']['data_nascimento'],
                'pes_sexo' => $data['pessoa']['sexo'] ?? null,
                'pes_mae' => $data['pessoa']['mae'] ?? null,
                'pes_pai' => $data['pessoa']['pai'] ?? null
            ]);

            if (!empty($data['foto']['base64'])) {
                $caminho = $this->armazenarFotoNoMinio($data['foto']['base64'], $data['st_matricula']);
                if ($caminho) {
                    FotoPessoa::create([
                        'pes_id' => $pessoa->pes_id,
                        'fp_base64' => $caminho,
                        'fp_bucket' => 'meu-bucket',
                        'fp_data' => now(),
                        'fp_hash' => md5($data['foto']['base64']),
                    ]);
                }
            }

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $data['endereco']['tipo_logradouro'],
                'end_logradouro' => $data['endereco']['logradouro'],
                'end_numero' => $data['endereco']['numero'],
                'end_bairro' => $data['endereco']['bairro'],
                'cid_id' => $data['endereco']['cid_id']
            ]);

            PessoaEndereco::create([
                'pes_id' => $pessoa->pes_id,
                'end_id' => $endereco->end_id
            ]);

            Lotacao::create([
                'pes_id' => $pessoa->pes_id,
                'unid_id' => $data['lotacao']['unid_id'],
                'lot_data_lotacao' => $data['lotacao']['lot_data_lotacao'],
                'lot_portaria' => $data['lotacao']['lot_portaria'] ?? null
            ]);

            return ServidorTemporario::create([
                'pes_id' => $pessoa->pes_id,
                'st_matricula' => $data['st_matricula']
            ]);
        });
    }

    public function listarTodos()
    {
        return ServidorTemporario::with([
            'pessoa.foto',
            'pessoa.enderecos.endereco.cidade',
            'pessoa.lotacoes.unidade'
        ])->get();
    }

    public function buscarPorId($id): ?ServidorTemporario
    {
        return ServidorTemporario::with([
            'pessoa.foto',
            'pessoa.enderecos.endereco.cidade',
            'pessoa.lotacoes.unidade'
        ])->findOrFail($id);
    }

    public function deletar($id): void
    {
        $registro = ServidorTemporario::findOrFail($id);
        $registro->delete();
    }

    public function atualizar($id, array $data): ServidorTemporario
    {
        return DB::transaction(function () use ($id, $data) {
            $registro = ServidorTemporario::with(['pessoa', 'pessoa.foto', 'pessoa.enderecos.endereco', 'pessoa.lotacoes'])->findOrFail($id);

            $registro->update([
                'st_matricula' => $data['st_matricula'] ?? $registro->st_matricula
            ]);

            $pessoa = $registro->pessoa;
            $pessoa->update([
                'pes_nome' => $data['pessoa']['nome'] ?? $pessoa->pes_nome,
                'pes_data_nascimento' => $data['pessoa']['data_nascimento'] ?? $pessoa->pes_data_nascimento,
                'pes_sexo' => $data['pessoa']['sexo'] ?? $pessoa->pes_sexo,
                'pes_mae' => $data['pessoa']['mae'] ?? $pessoa->pes_mae,
                'pes_pai' => $data['pessoa']['pai'] ?? $pessoa->pes_pai
            ]);

            if (!empty($data['foto']['base64'])) {
                $caminho = $this->armazenarFotoNoMinio($data['foto']['base64'], $data['st_matricula']);

                if ($caminho) {
                    $foto = $registro->foto ?: new FotoPessoa(['pes_id' => $registro->pes_id]);

                    $foto->fp_base64 = $caminho;
                    $foto->fp_data = now();
                    $foto->fp_bucket = 'meu-bucket';
                    $foto->fp_hash = md5($data['foto']['base64']);

                    $foto->save();
                }
            }

            if (isset($data['endereco'])) {
                $enderecoExistente = optional($pessoa->enderecos->first())->endereco;
                if ($enderecoExistente) {
                    $enderecoExistente->update([
                        'end_tipo_logradouro' => $data['endereco']['tipo_logradouro'] ?? $enderecoExistente->end_tipo_logradouro,
                        'end_logradouro' => $data['endereco']['logradouro'] ?? $enderecoExistente->end_logradouro,
                        'end_numero' => $data['endereco']['numero'] ?? $enderecoExistente->end_numero,
                        'end_bairro' => $data['endereco']['bairro'] ?? $enderecoExistente->end_bairro,
                        'cid_id' => $data['endereco']['cid_id'] ?? $enderecoExistente->cid_id
                    ]);
                }
            }

            if (isset($data['lotacao'])) {
                $lotacao = $pessoa->lotacoes->last();
                if ($lotacao) {
                    $lotacao->update([
                        'unid_id' => $data['lotacao']['unid_id'] ?? $lotacao->unid_id,
                        'lot_data_lotacao' => $data['lotacao']['lot_data_lotacao'] ?? $lotacao->lot_data_lotacao,
                        'lot_portaria' => $data['lotacao']['lot_portaria'] ?? $lotacao->lot_portaria
                    ]);
                }
            }

            return $registro->load([
                'pessoa.foto',
                'pessoa.enderecos.endereco.cidade',
                'pessoa.lotacoes.unidade'
            ]);
        });
    }

    protected function armazenarFotoNoMinio(string $base64, string $matricula): ?string
    {
        try {
            $dados = explode(',', $base64);
            $mime = explode(';', $dados[0])[0] ?? '';
            $conteudo = base64_decode($dados[1] ?? '');
            $extensao = str_contains($mime, 'image/png') ? 'png' : 'jpg';

            $nomeArquivo = "fotos/{$matricula}_" . uniqid() . ".{$extensao}";
            if (!empty($conteudo)) {
                Storage::disk('s3')->put($nomeArquivo, $conteudo);
                return $nomeArquivo;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function gerarUrlTemporaria(?string $caminho): ?string
    {
        if (!$caminho) {
            return null;
        }

        try {
            return Storage::disk('s3')->temporaryUrl(
                $caminho,
                now()->addMinutes(5)
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    public function armazenarMultiplasFotos($pes_id, string $matricula, array $fotos): array
    {
        $salvas = [];

        foreach ($fotos as $fotoData) {
            $caminho = $this->armazenarFotoNoMinio($fotoData['base64'], $matricula);

            if ($caminho) {
                $foto = FotoPessoa::create([
                    'pes_id' => $pes_id,
                    'fp_base64' => $caminho,
                    'fp_data' => now(),
                    'fp_bucket' => 'meu-bucket',
                    'fp_hash' => md5($fotoData['base64']),
                ]);

                $salvas[] = [
                    'id' => $foto->fp_id,
                    'url_temporaria' => Storage::disk('s3')->temporaryUrl($caminho, now()->addMinutes(5))
                ];
            }
        }

        return $salvas;
    }
}
