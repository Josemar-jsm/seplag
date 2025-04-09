<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use App\Repositories\UnidadeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Description of ServidorTemporarioController
 *
 * @author josemarsilva
 */

class UnidadeController extends Controller
{
    private UnidadeRepository $unidadeRepository;

    public function __construct()
    {
        $this->unidadeRepository = new UnidadeRepository();
    }

    public function index()
    {
        try {
            return $this->unidadeRepository->listarTodos();
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro ao listar unidades',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreUnidadeRequest $request)
    {
        try {
            return $this->unidadeRepository->criar($request->validated());
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro ao cadastrar unidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            return $this->unidadeRepository->buscarPorId($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Unidade não encontrada',
                'id' => $id
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro ao buscar unidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateUnidadeRequest $request, $id)
    {
        try {
            return $this->unidadeRepository->atualizar($id, $request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Unidade não encontrada para atualização',
                'id' => $id
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro ao atualizar unidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->unidadeRepository->deletar($id);
            return response()->json(['message' => 'Unidade removida com sucesso.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Unidade não encontrada para exclusão',
                'id' => $id
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro ao excluir unidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
