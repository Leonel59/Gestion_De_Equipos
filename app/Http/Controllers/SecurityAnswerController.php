<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecurityAnswerController extends Controller
{
    public function resetPasswordWithAnswer(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'security_answer' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->security_answer, $user->security_answer)) {
            // Si la respuesta de seguridad coincide, se actualiza la contraseña
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('status', 'Contraseña restablecida exitosamente. Puedes iniciar sesión con tu nueva contraseña.');
        }

        return back()->withErrors(['security_answer' => 'La respuesta es incorrecta.']);
    }
}

