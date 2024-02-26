<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Traits\BaseUserTraits;

class CashierUserController extends Controller
{
    use BaseUserTraits;

    /**
     * Display a listing of the resource.
     *
     * *Get all cashiers.
     */
    public function index()
    {
        return $this->getUsers(4);
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
     * *Create a new cashier.
     */
    public function store(CreateUserRequest $request)
    {
        return $this->addUser($request, 4);
    }

    /**
     * Display the specified resource.
     *
     * *Get detail cashier.
     */
    public function show(string $id)
    {
        return $this->getUser((int)$id, 4);
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
     * * Update name and username of cashier.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        return $this->updateInfo($request, (int)$id, 4);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
