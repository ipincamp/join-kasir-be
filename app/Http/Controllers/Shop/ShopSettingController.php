<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\SettingShopRequest;
use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\User;

class ShopSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * * View shop settings.
     */
    public function show(string $id)
    {
        $shop = Shop::find((int)$id);

        if ($shop) {
            $setting = $shop->shopSetting;

            return $this->response(200, 'Berhasil mendapatkan pengaturan toko.', $setting);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * * Make changes to shop settings.
     */
    public function update(SettingShopRequest $request, string $id)
    {
        $user = User::find(auth()->user()->id);
        $shopOwner = $user->shopOwners->where('shop_id', $id)->first();

        if ($shopOwner) {
            $shop = $shopOwner->shop;

            if ($shop) {
                $setting = $shop->shopSetting ?? new ShopSetting;

                $setting->address = $request['alamat_toko'];
                $setting->name = $request['nama_toko'];
                $setting->motd = $request['motd_toko'];
                $setting->header = $request['nota_atas'];
                $setting->footer = $request['nota_bawah'];
                $setting->created_by = auth()->user()->id;

                if ($shop->shopSetting) {
                    $setting->updated_by = auth()->user()->id;
                }

                $shop->shopSetting()->save($setting);

                return $this->response(200, 'Pengaturan toko berhasil diperbarui.', $shop);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
