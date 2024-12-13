<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {

    public function register(UserRequest $request) {
        // si los datos son correctos crear usuario
        $user = User::create($request->all());

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => new UserResource($user),
        ]);

    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario con las credenciales proporcionadas
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Usuario o contraseña incorrectos',
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken($user->email, [$request->can] )->plainTextToken;

        return response()->json([
            'message' => 'Usuario logueado correctamente',
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

}
