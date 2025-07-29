<?php

namespace App\Repositories;

use App\Models\TransactionVoucherUsage;

class TransactionVoucherUsageRepository
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
        return TransactionVoucherUsage::create($data);
    }

    public function update(TransactionVoucherUsage $transactionVoucherUsage, array $data)
    {
        return $transactionVoucherUsage->update($data);
    }

    public function delete(TransactionVoucherUsage $transactionVoucherUsage)
    {
        return $transactionVoucherUsage->delete();
    }

    public function findById($id)
    {
        return TransactionVoucherUsage::where('id', $id)->with(['voucher.mVoucherType'])->first();
    }

    public function getAll()
    {
        return TransactionVoucherUsage::with(['voucher.mVoucherType'])->get();
    }

    public function getByOutletId($outletId)
    {
        return TransactionVoucherUsage::with(['voucher.mVoucherType'])
            ->whereHas('voucher', function ($query) use ($outletId) {
                $query->where('outlet_id', $outletId);
            })->get();
    }
}
