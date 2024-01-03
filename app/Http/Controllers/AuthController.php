<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['User not found.'],
            ]);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email or password is invalid.'],
            ]);
        }

        Auth::attempt(['email' => $user->email, 'password' => $request->input('password')], $request->boolean('remember_me'));

        return redirect()->route('homepage');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        Auth::attempt(['email' => $user->email, 'password' => $request->input('password')]);

        return redirect()->route('homepage');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('homepage');
    }
}
