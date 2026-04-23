<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\usuariosController;



Route::post('/login', [usuariosController::class, 'login_usu']);

Route::post('/registrar', [usuariosController::class, 'registrar_usu']);

