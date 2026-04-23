<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\usuariosController;

Route::get('/usuario', [usuariosController::class, 'index']);



Route::get('/registrar', function (){
  return 'Index Registrar';



  
});

Route::post('/registrar_estudiante/', [usuariosController::class, 'validar'] );

