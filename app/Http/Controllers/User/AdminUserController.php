<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Get all users (active or removed).
     */
    public function allUsers()
    {
        $users = User::withTrashed()->where('level', '!=', 1)->get();

        return new ApiResponse(
            new UserResource($users),
            200,
            'Berhasil mendapatkan semua data pengguna.'
        );
    }

    /**
     * Get all users (active).
     */
    public function active()
    {
        $users = User::where('level', '!=', 1)->get();

        return new ApiResponse(
            new UserResource($users),
            200,
            'Berhasil mendapatkan semua data pengguna aktif.'
        );
    }

    /**
     * Get all users (removed).
     */
    public function deleted()
    {
        $users = User::where('level', '!=', 1)->get();

        return new ApiResponse(
            new UserResource($users),
            200,
            'Berhasil mendapatkan semua data pengguna yang dihapus.'
        );
    }

    /**
     * Reset password other user.
     */
    public function resetPassword(ResetPasswordUserRequest $request, string $id)
    {
        $user = User::where('level', '!=', 1)->find($id);
        $admin = auth()->user();

        if (!$user) {
            return new ApiResponse([], 403, 'Pengguna tidak ditemukan.');
        }

        if (!Hash::check($request['password'], $admin->password)) {
            return new ApiResponse([], 400, 'Kata sandi Anda tidak benar.');
        }

        $user->update([
            'password' => Hash::make($request['new_password']),
            'updated_by' => $admin->id
        ]);

        return new ApiResponse($user, 200, 'Kata sandi pengguna berhasil direset.');
    }

    /**
     * Soft delete other user.
     */
    public function tempoRemove(string $id)
    {
        $user = User::where('level', '!=', 1)->find($id);

        if (!$user) {
            return new ApiResponse([], 403, 'Pengguna tidak ditemukan.');
        }

        $user->update([
            'updated_by' => auth()->user()->id,
            'deleted_by' => auth()->user()->id
        ]);

        $user->delete();

        return new ApiResponse([], 200, 'Pengguna berhasil dihapus.');
    }

    /**
     * Permanent delete other user.
     */
    public function permaRemove(string $id)
    {
        $user = User::withTrashed()->where('level', '!=', 1)->find($id);

        if (!$user) {
            return new ApiResponse([], 403, 'Pengguna tidak ditemukan.');
        }

        $user->forceDelete();

        return new ApiResponse([], 200, 'Pengguna berhasil dihapus (permanen).');
    }
}
