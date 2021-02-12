<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        Log::debug("Metodo Store del UserController");
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique',
            'password' => 'required',
            'email' => 'required|email',
            'role' => 'required|max:5',
            'device_name' => 'required'
        ]);

        if ($validator->fails()) {
            Log::debug("Metodo Store del UserController - Datos incompletos");
            return response()->json(['message' => 'Incomplete data'], 422);
        }
        $user = User::where('name', $request->name)
            ->orWhere('email', $request->email)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'role' => $request->role,
            ]);
            Log::debug("Metodo Store del UserController - Usuario creado con exito [" . $user->name . "]");
            return response()->json([
                'message' => 'Usuario creado con exito',
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ], 201);
        }
        Log::debug("Metodo Store del UserController - Usuario debe cambiar las credenciales");
        return response()->json([
            'message' => 'Error en las credenciales'
        ], 400);
    }
}
