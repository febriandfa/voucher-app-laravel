<?php

namespace App\Repositories;

use App\Models\TransactionVoucherReceipt;

class TransactionVoucherReceiptRepository
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
        return TransactionVoucherReceipt::create($data);
    }

    public function update(TransactionVoucherReceipt $transactionVoucherReceipt, array $data)
    {
        return $transactionVoucherReceipt->update($data);
    }

    public function delete(TransactionVoucherReceipt $transactionVoucherReceipt)
    {
        return $transactionVoucherReceipt->delete();
    }

    public function findById($id)
    {
        return TransactionVoucherReceipt::where('id', $id)->with(['voucher.mVoucherType', 'recipient'])->first();
    }

    public function findByVoucherIdRecipientId($voucherId, $recipientId)
    {
        return TransactionVoucherReceipt::where('voucher_id', $voucherId)
            ->where('recipient_id', $recipientId)
            ->with(['voucher.mVoucherType', 'recipient'])
            ->first();
    }

    public function getAll()
    {
        return TransactionVoucherReceipt::with(['voucher.mVoucherType', 'recipient'])->get();
    }

    public function getByOutletId($outletId)
    {
        return TransactionVoucherReceipt::with(['voucher.mVoucherType', 'recipient'])
            ->whereHas('voucher', function ($query) use ($outletId) {
                $query->where('outlet_id', $outletId);
            })->get();
    }
}
