<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use \App\Http\Controllers\Traits\ApiResponse;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

/**
 * Description of AuthApiController
 *
 * @author josemarsilva
 */
class AuthApiController {

    use ApiResponse;

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse('Invalid credentials', 'Invalid credentials', Response::HTTP_BAD_REQUEST);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return $this->errorResponse('error', $ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->successResponse('', 'Logout realizado com sucesso', Response::HTTP_OK);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return $this->errorResponse('error', $ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return $this->errorResponse('error', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return $this->successResponse(compact('user'), 'Consulta realizada com sucesso', Response::HTTP_OK);
    }

    protected function respondWithToken($token)
    {
        // Obtém o usuário autenticado
        $user = JWTAuth::user();

        $data = [
            'data' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'bearer',
        ];

        return $this->successResponse($data, 'Logado com sucesso', Response::HTTP_OK);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return $this->errorResponse('error', $ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
