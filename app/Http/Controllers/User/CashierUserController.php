<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CashierUserController extends Controller
{
    /**
     * Get all cashiers.
     */
    public function index()
    {
        $cashiers = User::where('level', 4)->get();
        $data = count($cashiers) < 1 ? [] : UserResource::collection($cashiers);
        $message = count($cashiers) < 1 ? 'Data kasir masih kosong.' : 'Berhasil mendapatkan semua data kasir.';

        return new ApiResponse($data, 200, $message);
    }

    /**
     * Create new cashier.
     */
    public function store(CreateUserRequest $request)
    {
        $kasir = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => 4,
            'pin' => false,
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse(
            new UserResource($kasir),
            201,
            'Kasir berhasil ditambahkan.'
        );
    }

    /**
     * Update name of cashier.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $cashier = User::where('level', 4)->find($id);

        if (!$cashier) {
            return new ApiResponse([], 400, 'Kasir tidak ditemukan.');
        }

        $data = [];

        if ($request['name']) {
            $data['name'] = $request['name'];
            $data['updated_by'] = auth()->user()->id;
        }

        if ($request['username']) {
            if ($request['username'] != $cashier->username) {
                $exist = User::where('level', 3)->where('username', $request['username'])->first();

                if ($exist) {
                    return new ApiResponse([], 400, 'Username sudah dipakai.');
                }
            }

            $data['username'] = $request['username'];
            $data['updated_by'] = auth()->user()->id;
        }

        $cashier->update($data);

        return new ApiResponse(new UserResource($cashier), 200, 'Data kasir berhasil diubah.');
    }
}
