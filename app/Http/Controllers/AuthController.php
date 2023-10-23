<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $request->validated();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();


        return response()->json([
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        /* autenticar el usuario  */
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' =>  [['El correo o la contraseña son incorrectos']]
            ], 401);
        }
        $token = Auth::user()->createToken('token')->plainTextToken;

        return response()->json([
            'user' => Auth::user(),
            'token' =>  $token
        ])->withCookie(cookie('basura',  $token, 60 * 24));
    }


    public function logout()
    {

        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada exitosamente']);
        }

        return response()->json(['message' => 'No se pudo cerrar la sesión'], 400);
    }
}
