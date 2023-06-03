<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->generateResponse(
                'faield',
                'The provided credentials are incorrect',
                401
            );
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->generateResponse(
            'success',
            'Successfully logged in',
            Response::HTTP_OK,
            [
                'token' => $token
            ]
        );
    }
}
