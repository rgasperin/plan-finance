<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Esse campo de email é obrigatório',
            'email.email' => 'Esse campo tem que ter um email válido',
            'password.required' => 'Esse campo password é obrigatório',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return redirect('login')->with('error', 'E-mail ou senha invalidos!');
        }

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return redirect('login')->withErrors(['error' => 'E-mail ou senha inválidos!']);
        }

        Auth::loginUsingId($user->id);

        return redirect('/')->with('success', 'Login feito com sucesso');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('login')->with('success', "Você foi deslogado com sucesso!");
    }
}
