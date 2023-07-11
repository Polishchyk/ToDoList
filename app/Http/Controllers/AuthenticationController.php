<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function login(LoginRequest $request)
    {
        $attr = $request->validated();

        if( !Auth::attempt([
            'email' => $attr['email'],
            'password' => $attr['password']
        ])){

           return response()->json([
                'message' => 'Credentials not match',
            ], 401);
        }


        return [
            'token' => auth()->user()->createToken('token')->plainTextToken
        ];
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
