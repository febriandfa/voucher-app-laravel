<?php

namespace App\Services;

use App\Repositories\TransactionVoucherReceiptRepository;

class TransactionVoucherReceiptService
{
    /**
     * Create a new class instance.
     */

    protected $transactionVoucherReceiptRepository;

    public function __construct(TransactionVoucherReceiptRepository $transactionVoucherReceiptRepository)
    {
        $this->transactionVoucherReceiptRepository = $transactionVoucherReceiptRepository;
    }

    public function delete($id)
    {
        $voucherReceipt = $this->transactionVoucherReceiptRepository->findById($id);

        if (!$voucherReceipt) {
            throw new \Exception('Transaction voucher receipt not found');
        }

        return $this->transactionVoucherReceiptRepository->delete($voucherReceipt);
    }

    public function findById($id)
    {
        return $this->transactionVoucherReceiptRepository->findById($id);
    }

    public function getAll()
    {
        return $this->transactionVoucherReceiptRepository->getAll();
    }

    public function getByOutletId($outletId)
    {
        return $this->transactionVoucherReceiptRepository->getByOutletId($outletId);
    }
}
