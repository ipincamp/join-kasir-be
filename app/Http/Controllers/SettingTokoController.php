<?php

namespace App\Http\Controllers;

use App\Http\Requests\Toko\SettingTokoRequest;
use App\Http\Responses\ApiResponse;
use App\Models\SettingToko;
use App\Models\Toko;

class SettingTokoController extends Controller
{
    /**
     * Get all settings.
     */
    public function index(string $kode)
    {
        $settings = SettingToko::where('kode_toko', (int)$kode)
            ->select('key', 'value', 'description')
            ->orderBy('sequence', 'asc')
            ->get();

        return new ApiResponse($settings, 200, 'Berhasil mendapatkan semua setting.');
    }

    /**
     * Create initial settings.
     */
    public function store(SettingTokoRequest $request, string $kode)
    {
        $toko = Toko::where('kode', (int)$kode)->first();

        if (!$toko) {
            return new ApiResponse([], 403, 'Toko tidak ditemukan.');
        }

        $setting = SettingToko::where('kode_toko', $toko->kode)->get();

        if (count($setting) > 5) {
            return new ApiResponse([], 403, 'Toko sudah pernah disetting.');
        }

        $settings = [
            ['site-address', $request['site_address'], 1, 'Alamat'],
            ['site-name', $request['site_name'], 2, 'Nama'],
            ['note-header', $request['note_header'], 3, 'Ucapan'],
            ['site-motd', $request['site_motd'], 4, 'Home'],
            ['note-footer', $request['note_footer'], 5, 'Letter'],
        ];
        $data = [];

        foreach ($settings as $set) {
            $data[] = [
                'key' => $set[0],
                'value' => $set[1],
                'sequence' => (int)$set[2],
                'description' => $set[3],
                'kode_toko' => $toko->kode,
                'created_at' => now(),
                'created_by' => auth()->user()->id
            ];
        }

        SettingToko::insert($data);

        return new ApiResponse($setting, 201, 'Berhasil menyimpan pengaturan toko.');
    }
}
