<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class SecureAuthController extends Controller
{
    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::driver('argon2id')->make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registrasi berhasil dan aman.',
            'user'    => $user
        ], 201);
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.'
            ], 429);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login berhasil.'
            ], 200);
        }

        RateLimiter::hit($throttleKey, 60);

        return response()->json([
            'message' => 'Kredensial tidak valid.'
        ], 401);
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Anda telah logout');
    }
}
