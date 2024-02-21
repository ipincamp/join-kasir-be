<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Http\Requests\Toko\SettingTokoRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Toko;

class SettingTokoController extends Controller
{
    /**
     * Create setting of toko.
     */
    public function store(SettingTokoRequest $request, string $kode)
    {
        $toko = Toko::where('kode', (int)$kode)->first();

        if (!$toko) {
            return new ApiResponse([], 400, 'Toko tidak ditemukan.');
        }

        $toko->update([
            'site_address' => $request['address'],
            'site_name' => $request['name'],
            'site_motd' => $request['motd'],
            'site_header' => $request['header'],
            'site_footer' => $request['footer'],
            'updated_by' => auth()->user()->id]
        );

        return new ApiResponse($toko, 201, 'Berhasil menyimpan pengaturan toko.');
    }

    /**
     * Get all settings.
     */
    public function show(string $kode)
    {
        $setting = Toko::where('kode', (int)$kode)->select('site_name', 'site_address', 'site_motd', 'site_header', 'site_footer')->first();

        return new ApiResponse($setting, 200, 'Berhasil mendapatkan pengaturan toko.');
    }
}
