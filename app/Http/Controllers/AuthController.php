<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\LogoutAuthRequest;
use App\Http\Resources\UserResource;
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
            return new ApiResponse([], 400, 'Identitas tidak sesuai dengan data kami.');
        }

        $user = $request->user();

        if (count($user->tokens) >= 1) {
            return new ApiResponse([], 403, 'Anda sudah login.');
        }

        $role = config('global.roles')[(int)$user->level - 1];
        $token = $user->createToken('login', [$role])->plainTextToken;

        return new ApiResponse(
            [
                'user' => new UserResource($user),
                'token' => $token
            ],
            200,
            'Login berhasil.'
        );
    }

    /**
     * Profile.
     */
    public function profile()
    {
        $user = auth()->user();

        return new ApiResponse(new UserResource($user), 200, 'Berhasil mendapatkan informasi Anda.');
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
