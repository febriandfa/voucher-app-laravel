<?php

namespace App\Services;

use App\Repositories\TransactionVoucherUsageRepository;

class TransactionVoucherUsageService
{
    /**
     * Create a new class instance.
     */

    protected $transactionVoucherUsageRepository;

    public function __construct(TransactionVoucherUsageRepository $transactionVoucherUsageRepository)
    {
        $this->transactionVoucherUsageRepository = $transactionVoucherUsageRepository;
    }

    public function delete($id)
    {
        $voucherUsage = $this->transactionVoucherUsageRepository->findById($id);

        if (!$voucherUsage) {
            throw new \Exception('Transaction voucher usage not found');
        }

        return $this->transactionVoucherUsageRepository->delete($voucherUsage);
    }

    public function findById($id)
    {
        return $this->transactionVoucherUsageRepository->findById($id);
    }

    public function getAll()
    {
        return $this->transactionVoucherUsageRepository->getAll();
    }
}
