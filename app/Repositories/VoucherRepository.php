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
        return Voucher::where('id', $id)->with(['outlet', 'mVoucherType', 'transactionVoucherReceipts'])->first();
    }

    public function getAll()
    {
        return Voucher::with(['outlet', 'mVoucherType'])->get();
    }

    public function getByOutletId($outletId)
    {
        return Voucher::where('outlet_id', $outletId)->with(['outlet', 'mVoucherType'])->get();
    }

    public function getActiveByOutletId($outletId)
    {
        return Voucher::where('outlet_id', $outletId)->where('status', 'active')->with(['outlet', 'mVoucherType'])->get();
    }

    public function getActive()
    {
        return Voucher::where('status', 'active')->with(['outlet', 'mVoucherType'])->get();
    }
}
