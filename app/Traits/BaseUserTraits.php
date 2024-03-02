<?php

namespace App\Traits;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\ShopOwner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait BaseUserTraits
{
    use BaseTraits;

    /**
     * Create a new user and associate with their shop.
     */
    public function addUser(CreateUserRequest $request, int $level)
    {
        dd($request->path());
        if ($level <= 1) {
            return $this->response(403, 'Anda tidak diperbolehkan untuk melakukan itu.');
        }

        if ($level > 2 && count($request['toko']) > 1) {
            return $this->response(403, 'Anda hanya dapat menambahkan banyak toko kepada pemilik.');
        }

        $role = $this->getPeran($level - 1);
        $user = User::create([
            'name' => $request['nama'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'level' => $level,
            'created_by' => auth()->user()->id
        ]);
        $shopOwners = [];

        foreach ($request['toko'] as $shop_id) {
            $shopOwners[] = [
                'user_id' => $user->id,
                'shop_id' => (int)$shop_id,
                'created_at' => now(),
            ];
        }

        ShopOwner::insert($shopOwners);
        // $owners = ShopOwner::where('user_id', $user->id)->get();

        return $this->response(201, $role . ' berhasil ditambahkan.', $user);
    }

    /**
     * Get a user with reference to his id and level.
     */
    public function getUser(int $id, int $level)
    {
        $users = User::where('level', $level)->find($id);
        $role = config('api.peran')[$level - 1];

        if (!$users) {
            return $this->response(400, $role . ' tidak ditemukan.');
        }

        return $this->response(200, 'Berhasil mendapatkan data ' . $role . '.', $users);
    }

    /**
     * Get all user with reference to his level.
     */
    public function getUsers(int $level)
    {
        // $users = User::with('shops:code,name')->get();
        $users = User::role('writer')->get();
        $users = User::where('level', $level)->get();
        $role = config('api.peran')[$level - 1];

        if (count($users) == 0) {
            return $this->response(200, $role . ' masih kosong.');
        }

        return $this->response(200, 'Berhasil mendapatkan semua data ' . $role . '.', $users);
    }

    /**
     * Modify name and username.
     */
    public function updateInfo(UpdateUserRequest $request, int $id, int $level)
    {
        $user = User::where('level', $level)->find($id);
        $role = config('api.peran')[$level - 1];

        if (!$user) {
            return $this->response(400, $role . ' tidak ditemukan.');
        }

        $username = $request['username'];

        if (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
            return $this->response(400, 'Username itu sudah digunakan oleh pengguna lain.');
        }

        $user->update([
            'name' => $request['nama'],
            'username' => $username,
            'updated_by' => auth()->user()->id,
        ]);

        return $this->response(200, $role . ' berhasil diupdate.', $user);
    }
}
