<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('pos');
        }

        if ($request->has('redirect')) {
            session(['url.intended' => $request->input('redirect')]);
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'El correo electrónico o nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $loginInput = trim($credentials['login']);
        $remember = $request->has('remember');

        // Check if input is email or username
        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (isset($user->is_active) && !$user->is_active) {
                return back()->withErrors([
                    'login' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.',
                ])->withInput($request->only('login', 'remember'));
            }

            Auth::login($user, $remember);
            $request->session()->regenerate();

            $intendedUrl = session()->pull('url.intended', route('pos'));
            
            return redirect($intendedUrl)->with('status', '¡Bienvenido de nuevo, ' . $user->name . '!');
        }

        return back()->withErrors([
            'login' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
        ])->withInput($request->only('login', 'remember'));
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pos')->with('status', 'Has cerrado sesión correctamente. Puedes seguir explorando el menú.');
    }
}
