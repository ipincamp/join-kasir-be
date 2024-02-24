<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CreateShopRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Get all shop
     */
    public function index()
    {
        $shops = Shop::get();

        return $this->response(200, 'Berhasil mendapatkan semua toko.', $shops);
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
     *
     * Create new shop
     */
    public function store(CreateShopRequest $request)
    {
        $shop = Shop::create([
            'code' => (int)$request['code'],
            'name' => $request['name'],
            'created_by' => auth()->user()->id,
        ]);

        return $this->response(201, 'Toko berhasil dibuat.', $shop);
    }

    /**
     * Display the specified resource.
     *
     * Get detail
     */
    public function show(string $id)
    {
        $shop = Shop::find((int)$id);

        if (!$shop) {
            return $this->response(400, 'Toko tidak ditemukan.');
        }

        return $this->response(200, 'Berhasil mendapatkan detail toko.', $shop);
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
     * Update shop
     */
    public function update(UpdateShopRequest $request, string $id)
    {
        $shop = Shop::find((int)$id);

        if (!$shop) {
            return $this->response(400, 'Toko tidak ditemukan.');
        }

        $shop->update([
            'code' => (int)$request['code'],
            'name' => $request['name'],
            'updated_by' => auth()->user()->id,
        ]);

        return $this->response(200, 'Toko berhasil di update.', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * Delete shop
     */
    public function destroy(string $id)
    {
        $shop = Shop::find((int)$id);

        if (!$shop) {
            return $this->response(400, 'Toko tidak ditemukan.');
        }

        $shop->update([
            'deleted_by' => auth()->user()->id,
        ]);
        $shop->delete();

        return $this->response(200, 'Toko berhasil dihapus.');
    }

    /**
     * Deleted shop list
     */
    public function trash()
    {
        $shops = Shop::onlyTrashed()->get();

        return $this->response(200, 'Berhasil mendapatkan toko yang dihapus.', $shops);
    }

    /**
     * Restore deleted shop
     */
    public function restore(string $id)
    {
        $shop = Shop::onlyTrashed()->where('id', (int)$id)->first();

        if (!$shop) {
            return $this->response(400, 'Toko tidak ditemukan.');
        }

        $shop->update([
            'updated_by' => auth()->user()->id,
            'deleted_by' => null,
        ]);
        $shop->restore();

        return $this->response(200, 'Berhasil mendapatkan toko yang dihapus.', $shop);
    }
}
