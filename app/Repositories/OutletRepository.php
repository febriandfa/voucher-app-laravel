<?php

namespace App\Repositories;

use App\Models\Outlet;

class OutletRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Outlet::create($data);
    }

    public function update(Outlet $outlet, array $data)
    {
        return $outlet->update($data);
    }

    public function delete(Outlet $outlet)
    {
        return $outlet->delete();
    }

    public function findById($id)
    {
        return Outlet::where('id', $id)->with(['user'])->first();
    }

    public function getAll()
    {
        return Outlet::with(['user'])->get();
    }
}
