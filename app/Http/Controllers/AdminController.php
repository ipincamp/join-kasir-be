<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Update password.
     */
    public function updatePassword(UpdatePasswordUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new ApiResponse([], 403, 'Pengguna tidak ditemukan.');
        }

        if (!Hash::check($request['current_password'], $user->password)) {
            return new ApiResponse([], 400, 'Kata sandi lama tidak benar.');
        }

        $user->update([
            'password' => Hash::make($request['new_password']),
            'updated_by' => auth()->user()->id
        ]);

        return new ApiResponse([], 200, 'Kata sandi berhasil diubah.');
    }

    /**
     * Remove user.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new ApiResponse([], 403, 'Pengguna tidak ditemukan.');
        }

        $user->deleted_by = auth()->user()->id;
        $user->delete();

        return new ApiResponse([], 200, 'Pengguna berhasil dihapus.');
    }
}
