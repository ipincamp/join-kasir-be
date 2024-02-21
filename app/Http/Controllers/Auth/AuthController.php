<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\LogoutAuthRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginAuthRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogoutAuthRequest $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

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
