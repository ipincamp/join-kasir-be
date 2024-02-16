<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\LogoutAuthRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login.
     */
    public function login(LoginAuthRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return new ApiResponse([], 402, 'Identitas tidak sesuai dengan data kami.');
        }

        // TODO: validate license

        $user = Auth::user();
        // admin: 0, owner: 1, leader: 2, cashier: 3
        $abilities = ['admin', 'owner', 'leader', 'cashier'];
        $level = $user->level;

        if (count($user->tokens) > 0) {
            return new ApiResponse([], 403, 'Anda sudah login.');
        }

        return new ApiResponse([
            'user' => $user,
            'token' => $request
                ->user()
                ->createToken('login', [$abilities[$level] ?? 'cashier'])
                ->plainTextToken
        ], 200, 'Login berhasil.');
    }

    /**
     * Profile.
     */
    public function profile()
    {
        $user = Auth::user();

        return new ApiResponse(['user' => $user], 200, 'Berhasil mendapatkan informasi Anda.');
    }

    /**
     * Logout.
     */
    public function logout(LogoutAuthRequest $request)
    {
        $request->user()->currentAccessToken()->delete();

        return new ApiResponse([], 200, 'Logout berhasil.');
    }
}
