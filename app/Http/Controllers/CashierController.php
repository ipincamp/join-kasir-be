<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    /**
     * Get all cashiers.
     */
    public function index()
    {
        $cashiers = User::where('level', 4)->get();

        return new ApiResponse(
            count($cashiers) === 0 ? [] : $cashiers,
            200,
            'Berhasil mendapatkan semua data kasir.'
        );
    }

    /**
     * Create new cashier.
     */
    public function store(CreateUserRequest $request)
    {
        $cashier = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => 4,
            'pin' => 0,
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse($cashier, 201, 'Kasir berhasil ditambahkan.');
    }

    /**
     * Update name of cashier.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $cashier = User::where('level', 4)->find($id);

        if (!$cashier) {
            return new ApiResponse([], 403, 'Kasir tidak ditemukan.');
        }

        $cashier->update([
            'name' => $request['name'],
            'updated_by' => auth()->user()->id
        ]);

        return new ApiResponse($cashier, 200, 'Data kasir berhasil diubah.');
    }
}
