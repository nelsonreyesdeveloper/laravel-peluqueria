<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPasswordRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class RecuperarCuentaController extends Controller
{
    public function recuperar(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __('Enlace enviado con exito, revise su correo electrónico')], 200);
        } else {
            return response()->json(['errors' => [[$status]]], 422); // Puedes personalizar el código de respuesta HTTP según tu preferencia.
        }
    }

    public function reset(NewPasswordRequest $request)
    {
        $request->validated();

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => __('Contraseña actualizada con exito')], 200);
        } else {
            return response()->json(['errors' => [['Correo electronico o token no validos']]], 422);
        }
    }
}
