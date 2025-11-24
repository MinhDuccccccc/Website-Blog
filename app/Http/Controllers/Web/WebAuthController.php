<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    public function formLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('web.auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        }

        return redirect()
            ->route('web.auth.login')
            ->with('error', 'Login failed');
    }

    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }

    public function formRegister()
    {
        return view('web.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|min:6|confirmed',
            ],
            [
                'name.required'         => 'Please enter your full name.',
                'email.required'        => 'Please enter your email.',
                'email.email'           => 'Please enter a valid email address.',
                'email.unique'          => 'This email is already registered.',
                'password.required'     => 'Please enter your password.',
                'password.min'          => 'Password must be at least 6 characters.',
                'password.confirmed'    => 'Password confirmation does not match.',
            ]
        );

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()
            ->route('web.auth.login')
            ->with('success', 'Registration successful! Please login.');
    }
}
