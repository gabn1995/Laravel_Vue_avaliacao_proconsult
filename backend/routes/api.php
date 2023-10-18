<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamadoController;


//Rotas de autenticação
Route::get('/unauthenticated', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/signin', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'create']);
Route::post('/logout', [AuthController::class, 'logout']);
//Rotas de autenticação

//Rota para pegar chamados
Route::post('/chamados', [ChamadoController::class, 'chamados']);
//Rota para adicionar chamado
Route::post('/chamado', [ChamadoController::class, 'adicionar_chamado']);
//Rota para responder chamado
Route::post('/chamado/responder', [ChamadoController::class, 'responder_chamado']);
//Rota para finalizar chamado
Route::post('/chamado/finalizar', [ChamadoController::class, 'finalizar_chamado']);