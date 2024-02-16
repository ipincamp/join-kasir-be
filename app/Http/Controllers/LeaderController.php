<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LeaderController extends Controller
{
    /**
     * Get all leaders.
     */
    public function index()
    {
        $leaders = User::where('level', 2)->get();

        return new ApiResponse(
            count($leaders) === 0 ? null : $leaders,
            200,
            'Berhasil mendapatkan semua data.'
        );
    }

    /**
     * Create new leader.
     */
    public function store(CreateUserRequest $request)
    {
        $leader = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => 2,
            'pin' => 0,
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse($leader, 201, 'Kepala berhasil ditambahkan.');
    }

    /**
     * Update name and username of leader.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $leader = User::find($id);

        if (!$leader) {
            return new ApiResponse([], 403, 'Kepala tidak ditemukan.');
        }

        $leader->update([
            'name' => $request['name'],
            'username' => $request['username'],
            'updated_by' => auth()->user()->id
        ]);

        return new ApiResponse($leader, 200, 'Kepala berhasil diubah.');
    }
}
