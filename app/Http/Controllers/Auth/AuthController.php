<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * Login
     */
    public function store(LoginAuthRequest $request)
    {
        if (!Auth::attempt($request->only('username', 'password'), boolval($request['remember']))) {
            return $this->response(400, 'Identitas tidak sesuai dengan data kami.');
        }

        $user = $request->user();

        if (count($user->tokens) >= 1) {
            return $this->response(403, 'Anda sudah login.');
        }

        $role = config('api.roles')[(int)$user->level - 1];
        $expire = now()->addMinutes((int)config('sanctum.expiration'));
        $token = $user->createToken('login', [$role], $expire);

        return $this->response(200, 'Login berhasil.', [
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * Profile
     */
    public function show()
    {
        $user = auth()->user();

        return $this->response(200, 'Berhasil mendapatkan informasi Anda.', $user);
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
     *
     * Logout
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response(200, 'Logout berhasil.');
    }
}
