<?php

namespace App\Services;

use App\Repositories\RecipientRepository;
use App\Repositories\TransactionVoucherUsageRepository;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Validator;

class ClaimVoucherService
{
    /**
     * Create a new class instance.
     */
    protected $voucherRepository;
    protected $transactionVoucherUsageRepository;
    protected $recipientRepository;

    public function __construct(
        VoucherRepository $voucherRepository,
        TransactionVoucherUsageRepository $transactionVoucherUsageRepository,
        RecipientRepository $recipientRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->transactionVoucherUsageRepository = $transactionVoucherUsageRepository;
        $this->recipientRepository = $recipientRepository;
    }

    public function claim(array $data)
    {
        $validator = Validator::make($data, [
            'voucher_id' => 'required|integer',
            'email' => 'required|email|exists:recipients,email',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $voucher = $this->voucherRepository->findById($validatedData['voucher_id']);
        $recipient = $this->recipientRepository->findByEmail($validatedData['email']);

        if (!$voucher) {
            throw new \Exception('Voucher not found');
        }

        if ($voucher->status !== 'active') {
            throw new \Exception('Voucher is not active');
        }

        if ($voucher->tanggal_kadaluarsa < now()) {
            throw new \Exception('Voucher has expired');
        }

        if ($voucher->tanggal_terbit > now()) {
            throw new \Exception('Voucher has not started yet');
        }

        if ($voucher->transactionVoucherReceipts()->whereHas('recipient', function ($query) use ($validatedData) {
            $query->where('email', $validatedData['email']);
        })->exists()) {
            throw new \Exception('Voucher already claimed by this recipient');
        }

        $validatedData['keterangan_pemakaian'] = $recipient->no_wa . ' - ' . $recipient->email . ' - ' . $recipient->name;
        $validatedData['tanggal_pemakaian'] = now();

        return $this->transactionVoucherUsageRepository->create($validatedData);
    }
}
