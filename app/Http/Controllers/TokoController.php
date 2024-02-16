<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokoRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Toko;

class TokoController extends Controller
{
    /**
     * Get all toko.
     */
    public function index()
    {
        $tokos = Toko::all();
        $data = count($tokos) === 0 ? [] : $tokos;
        $message = count($tokos) === 0 ? 'Toko belum ada.' : 'Berhasil mendapatkan semua toko.';

        return new ApiResponse($data, 200, $message);
    }

    /**
     * Create new toko.
     */
    public function store(TokoRequest $request)
    {
        $toko = Toko::create([
            'kode' => (int)$request['kode'],
            'name' => $request['name'],
            'created_by' => auth()->user()->id
        ]);

        return new ApiResponse($toko, 201, 'Toko berhasil dibuat.');
    }

    /**
     * Get detail toko.
     */
    public function show(string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 404, 'Toko tidak ditemukan.');
        }

        // TODO: relation with setting

        return new ApiResponse($toko, 200, 'Berhasil mendapatkan informasi toko.');
    }

    /**
     * Update toko.
     */
    public function update(TokoRequest $request, string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 404, 'Toko tidak ditemukan.');
        }

        $toko->update($request->all());

        return new ApiResponse($toko, 200, 'Toko berhasil diperbarui.');
    }

    /**
     * Delete toko.
     */
    public function destroy(string $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return new ApiResponse([], 404, 'Toko tidak ditemukan.');
        }

        $toko->delete();

        return new ApiResponse([], 200, 'Toko berhasil dihapus.');
    }
}
