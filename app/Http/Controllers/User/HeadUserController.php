<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Traits\BaseUserTraits;
use Illuminate\Http\Request;

class HeadUserController extends Controller
{
    use BaseUserTraits;

    /**
     * Display a listing of the resource.
     *
     * *Get all heads.
     */
    public function index()
    {
        return $this->getUsers(3);
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
     * *Create a new head.
     */
    public function store(CreateUserRequest $request)
    {
        return $this->addUser($request, 3);
    }

    /**
     * Display the specified resource.
     *
     * *Get detail head.
     */
    public function show(string $id)
    {
        return $this->getUser((int)$id, 3);
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
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
