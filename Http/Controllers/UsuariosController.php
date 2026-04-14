<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    // GET /login
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('listado');
        }
 
        return view('usuarios.login');
    }
 
    // POST /login
    public function procesarLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);
 
        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('listado');
        }
 
        return back()
            ->withInput(['username' => $request->username])
            ->withErrors(['login' => 'Usuario o contraseña incorrectos.']);
    }
 
    // POST /logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('compra');
    }
}