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
        return TransactionVoucherUsage::where('id', $id)->with(['voucher'])->first();
    }

    public function getAll()
    {
        return TransactionVoucherUsage::with(['voucher'])->get();
    }
}
