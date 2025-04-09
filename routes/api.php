<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthApiController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\LotacaoController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthApiController::class, 'login'])->name('loginv1.auth');
    Route::post('/auth/logout', [AuthApiController::class, 'logout'])->name('logoutv1.auth');
    Route::post('/auth/forgot-password', [AuthApiController::class, 'forgotPassword'])->name('forgotv1.auth');

Route::middleware(['auth:api'])->group(function () {

        Route::get('servidores-efetivos/unidade/{unid_id}', [ServidorEfetivoController::class, 'lotadosNaUnidade']);
        Route::get('servidores-efetivos/endereco-funcional', [ServidorEfetivoController::class, 'enderecoFuncionalPorNome']);
        Route::get('servidores-efetivos/{id}/foto-temporaria', [ServidorEfetivoController::class, 'fotoTemporaria']);
        Route::post('servidores-efetivos/{id}/fotos',[ServidorEfetivoController::class, 'armazenarMultiplasFotos']);

        Route::apiResource('servidores-efetivos', ServidorEfetivoController::class);
        Route::apiResource('servidores-temporarios', ServidorTemporarioController::class);
        Route::apiResource('unidades', UnidadeController::class);
        Route::apiResource('lotacoes', LotacaoController::class);
        
    });
});
