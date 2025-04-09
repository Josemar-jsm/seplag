<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ServidorEfetivoRepository;
use App\Http\Requests\StoreServidorEfetivoRequest;
use App\Http\Requests\UpdateServidorEfetivoRequest;
use App\Http\Requests\DestroyServidorEfetivoRequest;
use App\Http\Requests\ShowServidorEfetivoRequest;
use App\Http\Resources\ServidorEfetivoResource;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Description of ServidorEfetivoController
 *
 * @author josemarsilva
 */
class ServidorEfetivoController extends Controller {

    private $servidorEfetivoRepository;

    public function __construct()
    {
        $this->servidorEfetivoRepository = new ServidorEfetivoRepository();
    }

    public function index()
    {
        try {
            $servidores = $this->servidorEfetivoRepository->listarTodos();
            return ServidorEfetivoResource::collection($servidores);
        } catch (\Throwable $e) {
            return response()->json([
                        'error' => 'Erro ao listar servidores efetivos',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function store(StoreServidorEfetivoRequest $request)
    {
        $data = $request->validated();

        try {
            $servidor = $this->servidorEfetivoRepository->criarServidorEfetivo($data);

            return new ServidorEfetivoResource(
                    $servidor->load([
                        'pessoa.foto',
                        'pessoa.enderecos.endereco.cidade',
                        'pessoa.lotacoes.unidade'
                    ])
            );
        } catch (ValidationException $e) {
            return response()->json([
                        'error' => 'Erro de validação',
                        'messages' => $e->errors()
                            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                        'error' => 'Erro interno ao cadastrar servidor efetivo',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function show(ShowServidorEfetivoRequest $request, $id)
    {
        try {
            $servidor = $this->servidorEfetivoRepository->buscarPorId($id);
            return new ServidorEfetivoResource($servidor);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                        'error' => 'Servidor efetivo não encontrado',
                        'id' => $id
                            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                        'error' => 'Erro interno ao buscar servidor',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function update(UpdateServidorEfetivoRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $servidor = $this->servidorEfetivoRepository->atualizar($id, $data);

            return new ServidorEfetivoResource($servidor);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                        'error' => 'Servidor efetivo não encontrado para atualização',
                        'id' => $id
                            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                        'error' => 'Erro de validação',
                        'messages' => $e->errors()
                            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                        'error' => 'Erro interno ao atualizar servidor efetivo',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function destroy(DestroyServidorEfetivoRequest $request, $id)
    {
        try {
            $this->servidorEfetivoRepository->deletar($id);
            return response()->json(['message' => 'Servidor efetivo removido com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                        'error' => 'Servidor efetivo não encontrado para exclusão',
                        'id' => $id
                            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                        'error' => 'Erro interno ao excluir servidor efetivo',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function lotadosNaUnidade($unid_id)
    {
        try {
            return response()->json(
                            $this->servidorEfetivoRepository->lotadosNaUnidade($unid_id)
                    );
        } catch (\Throwable $e) {
            return response()->json([
                        'error' => 'Erro ao consultar servidores lotados na unidade',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function enderecoFuncionalPorNome(Request $request)
    {
        try {
            $nome = $request->query('nome');
            return response()->json(
                            $this->servidorEfetivoRepository->enderecoFuncionalPorNome($nome)
                    );
        } catch (\Throwable $e) {
            return response()->json([
                        'error' => 'Erro ao buscar endereço funcional',
                        'message' => $e->getMessage()
                            ], 500);
        }
    }

    public function fotoTemporaria($id)
    {
        $servidor = $this->servidorEfetivoRepository->buscarPorId($id);

        $caminho = optional($servidor->pessoa->foto)->fp_base64;
        $url = $this->servidorEfetivoRepository->gerarUrlTemporaria($caminho);

        return response()->json([
                    'url_temporaria' => $url,
                    'expira_em' => now()->addMinutes(5)->toDateTimeString(),
        ]);
    }
    public function armazenarMultiplasFotos(Request $request, $id)
    {
        $request->validate([
            'fotos' => 'required|array',
            'fotos.*.base64' => 'required|string',
        ]);

        $servidor = $this->servidorEfetivoRepository->buscarPorId($id);
        $fotos = $this->servidorEfetivoRepository->armazenarMultiplasFotos(
            $servidor->pes_id,
            $servidor->se_matricula,
            $request->input('fotos')
        );

        return response()->json([
            'fotos_salvas' => $fotos
        ]);
    }
}
