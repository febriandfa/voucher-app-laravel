<?php

namespace App\Repositories;

use App\Models\MVoucherType;

class MVoucherTypeRepository
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
        return MVoucherType::create($data);
    }

    public function update(MVoucherType $mVoucherType, array $data)
    {
        return $mVoucherType->update($data);
    }

    public function delete(MVoucherType $mVoucherType)
    {
        return $mVoucherType->delete();
    }

    public function findById($id)
    {
        return MVoucherType::find($id);
    }

    public function getAll()
    {
        return MVoucherType::all();
    }
}
