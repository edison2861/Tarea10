<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class usuariosController extends Controller
{
    public function login_usu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario'  => 'required|string',
            'password' => 'required|string',
        ], [
            'usuario.required'  => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = Usuarios::where('usuario', $request->usuario)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso.',
            'data'    => [
                'id'       => $user->id,
                'usuario'  => $user->usuario,
                'correo'   => $user->correo,
                'telefono' => $user->telefono,
            ],
        ], 200);
    }

    public function registrar_usu(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'usuario'  => 'required|string|unique:usuarios,usuario',
            'correo'   => 'required|string|unique:usuarios,correo',
            'telefono' => 'required|string',
            'password' => 'required|string',
        ], [
            'usuario.required' => 'El nombre de usuario es obligatorio.',
            'usuario.unique'   => 'El usuario ya está en uso.',
            'correo.required'  => 'El correo es obligatorio.',
            'correo.unique'    => 'El correo ya está registrado.',
            'telefono.required'=> 'El teléfono es obligatorio.',
            'password.required'=> 'La contraseña es obligatoria.',
        ]);

        if ($validar->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors'  => $validar->errors(),
            ], 422);
        }

        $nuevo_usu = Usuarios::create([
            'usuario'  => $request->usuario,
            'correo'   => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        if (!$nuevo_usu) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado correctamente.',
            'data'    => [
                'id'       => $nuevo_usu->id,
                'usuario'  => $nuevo_usu->usuario,
                'correo'   => $nuevo_usu->correo,
                'telefono' => $nuevo_usu->telefono,
            ],
        ], 201);
    }
}