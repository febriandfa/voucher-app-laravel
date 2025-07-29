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
}
