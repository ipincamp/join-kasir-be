<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LeaderUserController extends Controller
{
    /**
     * Get all leaders.
     */
    public function index()
    {
        $leaders = User::where('level', 3)->get();
        $data = count($leaders) < 1 ? [] : UserResource::collection($leaders);
        $message = count($leaders) < 1 ? 'Data kepala masih kosong.' : 'Berhasil mendapatkan semua data kepala.';

        return new ApiResponse($data, 200, $message);
    }

    /**
     * Create new leader.
     */
    public function store(CreateUserRequest $request)
    {
        $kepala = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => 3,
            'pin' => false,
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse(
            new UserResource($kepala),
            201,
            'Kepala berhasil ditambahkan.'
        );
    }

    /**
     * Update name of leader.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $kepala = User::where('level', 3)->find($id);

        if (!$kepala) {
            return new ApiResponse([], 400, 'Kepala tidak ditemukan.');
        }

        $data = [];

        if ($request['name']) {
            $data['name'] = $request['name'];
            $data['updated_by'] = auth()->user()->id;
        }

        if ($request['username']) {
            if ($request['username'] != $kepala->username) {
                $exist = User::where('level', 3)->where('username', $request['username'])->first();

                if ($exist) {
                    return new ApiResponse([], 400, 'Username sudah dipakai.');
                }
            }

            $data['username'] = $request['username'];
            $data['updated_by'] = auth()->user()->id;
        }

        $kepala->update($data);

        return new ApiResponse(new UserResource($kepala), 200, 'Data kepala berhasil diubah.');
    }
}
