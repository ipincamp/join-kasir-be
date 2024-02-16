<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    /**
     * Get all owners.
     */
    public function index()
    {
        $owners = User::where('level', 1)->get();

        return new ApiResponse(
            count($owners) === 0 ? null : $owners,
            200,
            'Berhasil mendapatkan semua data.'
        );
    }

    /**
     * Create new owner.
     */
    public function store(CreateUserRequest $request)
    {
        $owner = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => 1,
            'pin' => boolval($request['pin']) ? 1 : 0,
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse($owner, 201, 'Owner berhasil ditambahkan.');
    }

    /**
     * Update name of owner.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $owner = User::find($id);

        if (!$owner) {
            return new ApiResponse([], 403, 'Owner tidak ditemukan.');
        }

        $owner->update([
            'name' => $request['name'],
            'updated_by' => auth()->user()->id
        ]);

        return new ApiResponse($owner, 200, 'Owner berhasil diubah.');
    }
}
