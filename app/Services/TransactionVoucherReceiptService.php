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
}
