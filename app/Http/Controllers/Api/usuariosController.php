<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usuariosController extends Controller
{
    public function index()
    {
        $usuario = Usuarios::all();
        
        // if ($usuario->isEmpty()){
        //     $data = [
        //         'message' => 'No existen usuarios registrados',
        //         'status' => 404
        //     ];

        //     return response()->json($data,404);
        // }

        $data = [
            'usuario' => $usuario,
            'status' => 200
        ];

        return response()->json($data, 200);
    }   


    public function validar(Request $request)
    {


        $val = Validator::make($request->all(),[
            'usuario' => 'required',
            'password' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
        ]);

        if ($val->fails()){
            $data = [

                'message' =>'Error en la validacion de datos',
                'errors' => $val->errors(),
                'status' => 400 

            ];
            return response ()->json ($data, 400);
        }

        $usuario = Usuarios::create ([
            'usuario'=> $request -> usuario,
            'password'=> $request -> password,
            'telefono'=> $request -> telefono, 
            'correo' => $request -> correo,
        ]);

        if (!$usuario) {
            $data = [
                'message' => 'Error al crear usuario',
                'status' => 500
            ];
            return response ()->json ($data, 500);
        }

        $data = [
            'usuario' => $usuario,
            'status' => 201
        ];
        return response () ->json ($data,201);
    }

}
