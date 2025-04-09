<?php
namespace App\Http\Controllers\Traits;
/**
 *
 * @author josemarsilva
 */
trait ApiResponse {

    /**
     * Retornar resposta de sucesso
     *
     * @param  mixed $data
     * @param  string $message
     * @param  int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = 'Success', $statusCode = 200)
    {
        return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'data' => $data,
                        ], $statusCode);
    }

    /**
     * Retornar resposta de erro
     *
     * @param  string $message
     * @param  mixed $errors
     * @param  int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $errors = null, $statusCode = 400)
    {
        return response()->json([
                    'status' => 'error',
                    'message' => $message,
                    'errors' => $errors,
                        ], $statusCode);
    }
}
