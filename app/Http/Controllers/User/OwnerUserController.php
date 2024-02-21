<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OwnerUserController extends Controller
{
    /**
     * Get all owners.
     */
    public function index()
    {
        $owners = User::where('level', 2)->get();
        $data = count($owners) < 1 ? [] : UserResource::collection($owners);
        $message = count($owners) < 1 ? 'Data pemilik masih kosong.' : 'Berhasil mendapatkan semua data pemilik.';

        return new ApiResponse($data, 200, $message);
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
            'level' => 2,
            'pin' => boolval($request['pin']),
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse(
            new UserResource($owner),
            201,
            'Pemilik berhasil ditambahkan.'
        );
    }

    /**
     * Update name of owner.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $owner = User::where('level', 2)->find($id);

        if (!$owner) {
            return new ApiResponse([], 400, 'Pemilik tidak ditemukan.');
        }

        $data = [];

        if ($request['name']) {
            $data['name'] = $request['name'];
            $data['updated_by'] = auth()->user()->id;
        }

        if ($request['username']) {
            if ($request['username'] != $owner->username) {
                $exist = User::where('level', 2)->where('username', $request['username'])->first();

                if ($exist) {
                    return new ApiResponse([], 400, 'Username sudah dipakai.');
                }
            }

            $data['username'] = $request['username'];
            $data['updated_by'] = auth()->user()->id;
        }

        $owner->update($data);

        return new ApiResponse(new UserResource($owner), 200, 'Data pemilik berhasil diubah.');
    }
}
