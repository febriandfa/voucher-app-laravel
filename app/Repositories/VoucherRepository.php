<?php

namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepository
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
        return Voucher::create($data);
    }

    public function update(Voucher $voucher, array $data)
    {
        return $voucher->update($data);
    }

    public function delete(Voucher $voucher)
    {
        return $voucher->delete();
    }

    public function findById($id)
    {
        return Voucher::where('id', $id)->with(['outlet', 'mVoucherType'])->first();
    }

    public function getAll()
    {
        return Voucher::with(['outlet', 'mVoucherType'])->get();
    }
}
