<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Asegúrate de importar Hash

class SecurityAnswerController extends Controller
{
    public function showForm()
    {
        return view('security-answer'); 
    }

    public function checkAnswer(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'security_answer' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->security_answer, $user->security_answer)) { // Verifica la respuesta
            Auth::login($user);
            return redirect()->intended('dashboard'); 
        }

        return back()->withErrors(['security_answer' => 'La respuesta es incorrecta.']);
    }
}
