<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    // GET /login — Muestra el formulario
    public function login(): View|RedirectResponse
    {
        if (session()->has('usuario')) {
            return redirect()->route('listado');
        }
        return view('usuarios.login');
    }

    // Procesa el login manua
    public function procesarLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Buscamos el usuario en la BD y verificamos hash
        $usuario = \App\Models\Usuario::where('username', $username)->first();

        if ($usuario && password_verify($password, $usuario->password)) {
            session(['usuario' => $username]);
            return redirect()->route('listado');
        }

        return back()
            ->withInput(['username' => $username])
            ->withErrors(['login' => 'Usuario o contraseña incorrectos.']);
    }

    // Cierra la sesión
    public function logout(): RedirectResponse
    {
        session()->forget('usuario');
        return redirect()->route('compra');
    }
}