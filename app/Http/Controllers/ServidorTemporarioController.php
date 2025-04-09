<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ServidorTemporarioRepository;
use App\Http\Requests\StoreServidorTemporarioRequest;
use App\Http\Requests\UpdateServidorTemporarioRequest;
use App\Http\Requests\DestroyServidorTemporarioRequest;
use App\Http\Requests\ShowServidorTemporarioRequest;
use App\Http\Resources\ServidorTemporarioResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * Description of ServidorTemporarioController
 *
 * @author josemarsilva
 */
class ServidorTemporarioController extends Controller {

    private $servidorTemporarioRepository;

    public function __construct()
    {
        $this->servidorTemporarioRepository = new ServidorTemporarioRepository();
    }

    public function index()
    {
        try {
            $servidores = $this->servidorTemporarioRepository->listarTodos();
            return ServidorTemporarioResource::collection($servidores);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro ao listar servidores temporários',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreServidorTemporarioRequest $request)
    {
        $data = $request->validated();

        try {
            $servidor = $this->servidorTemporarioRepository->criarServidorTemporario($data);

            return new ServidorTemporarioResource(
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
                'error' => 'Erro interno ao cadastrar servidor temporário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(ShowServidorTemporarioRequest $request, $id)
    {
        try {
            $servidor = $this->servidorTemporarioRepository->buscarPorId($id);
            return new ServidorTemporarioResource($servidor);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Servidor temporário não encontrado',
                'id' => $id
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro interno ao buscar servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateServidorTemporarioRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $servidor = $this->servidorTemporarioRepository->atualizar($id, $data);
            return new ServidorTemporarioResource($servidor);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Servidor temporário não encontrado para atualização',
                'id' => $id
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro interno ao atualizar servidor temporário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(DestroyServidorTemporarioRequest $request, $id)
    {
        try {
            $this->servidorTemporarioRepository->deletar($id);
            return response()->json(['message' => 'Servidor temporário removido com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Servidor temporário não encontrado para exclusão',
                'id' => $id
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro interno ao excluir servidor temporário',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
