<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin() {
        return view('frontend.auth.login');
    }

    public function postLogin(LoginRequest $request) {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => 0
        ];

        $remember = false;
        if($request->remember) {
            $remember = true;
        }
        if(auth()->attempt($login, $remember)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors('Email or password is incorrect');
        }

    }

    public function getRegister() {
        return view('frontend.auth.register');
    }

    public function postRegister(RegisterRequest $request) {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 0
        ];

        $registerUser = User::create($data);

        if($registerUser) {
            return redirect()->route('login');
        } else {
            return redirect()->back()->withErrors('Registration failed');
        }
    }

    public function logout() {
        auth()->logout();
        return redirect()->route('login');
    }
}
