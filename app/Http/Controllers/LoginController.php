<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::debug("Metodo Login del LoginController");
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);
        if ($validator->fails()) {
            Log::debug("Metodo Login del LoginController - Datos incompletos");
            return response()->json(['message' => 'Datos incompletos'], 422);
        }

        $user = User::where('name', $request->name)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::debug("Metodo Login del LoginController - Credenciales no validas");
            return response()->json(
                [
                    'message' => 'The given data was invalid.',
                    'errors' =>
                    [
                        'message' => 'The provided credentials are incorrect.'
                    ]
                ],
                401
            );
        }
        Log::debug("Metodo Login del LoginController - Usuario [" . $user->name . "]logeado con exito");
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function recovery(Request $request)
    {
        Log::debug("Metodo recovery del LoginController");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            Log::debug("Metodo recovery del LoginController - Datos incompletos");
            return response()->json($validator, 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            Log::debug("Metodo recovery del LoginController - Datos invalidos");
            return response()->json(
                [
                    'message' => 'The given data was invalid.',
                    'errors' =>
                    [
                        'message' => 'The provided credentials are incorrect.'
                    ]
                ],
                401
            );
        }
        $pass = Str::random(12);
        $password = bcrypt($pass);
        $user->password = $password;
        $user->save();
        Log::debug("Metodo recovery del LoginController - Usuario [" . $user->name . "] recupero su contraseña exitosamente");
        return response()->json([
            'password' => $pass,
        ], 200);
    }
}
