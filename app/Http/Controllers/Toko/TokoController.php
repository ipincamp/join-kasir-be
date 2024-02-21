<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Http\Requests\Toko\CreateTokoRequest;
use App\Http\Requests\Toko\UpdateTokoRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Toko;

class TokoController extends Controller
{
    /**
     * Get all tokos.
     */
    public function index()
    {
        $tokos = Toko::all();

        return new ApiResponse($tokos, 200, 'Berhasil mendapatkan semua data toko.');
    }

    /**
     * Create new toko.
     */
    public function store(CreateTokoRequest $request)
    {
        $toko = Toko::create([
            'kode' => (int)$request['kode'],
            'name' => $request['name'],
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse($toko, 201, 'Toko berhasil dibuat.');
    }

    /**
     * Get details of toko.
     */
    public function show(string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 400, 'Toko tidak ditemukan.');
        }

        return new ApiResponse($toko, 200, 'Berhasil mendapatkan informasi toko.');
    }

    /**
     * Update details of toko.
     */
    public function update(UpdateTokoRequest $request, string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 400, 'Toko tidak ditemukan.');
        }

        $data = [];

        if ($request['name']) {
            $data['name'] = $request['name'];
            $data['updated_by'] = auth()->user()->id;
        }

        if ($request['kode']) {
            if ($request['kode'] != $toko->kode) {
                $exist = Toko::where('kode', $request['kode'])->first();

                if ($exist) {
                    return new ApiResponse([], 400, 'Kode toko sudah dipakai.');
                }
            }

            $data['kode'] = (int)$request['kode'];
            $data['updated_by'] = auth()->user()->id;
        }

        $toko->update($data);

        return new ApiResponse($toko, 200, 'Toko berhasil diubah.');
    }

    /**
     * Remove toko.
     */
    public function destroy(string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 400, 'Toko tidak ditemukan.');
        }

        $toko->update([
            'deleted_by' => auth()->user()->id
        ]);
        $toko->delete();

        return new ApiResponse([], 200, 'Toko berhasil dihapus.');
    }
}
