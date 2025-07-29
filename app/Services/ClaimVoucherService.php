<?php

namespace App\Services;

use App\Repositories\RecipientRepository;
use App\Repositories\TransactionVoucherReceiptRepository;
use App\Repositories\TransactionVoucherUsageRepository;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClaimVoucherService
{
    /**
     * Create a new class instance.
     */
    protected $voucherRepository;
    protected $transactionVoucherUsageRepository;
    protected $transactionVoucherReceiptRepository;
    protected $recipientRepository;

    public function __construct(
        VoucherRepository $voucherRepository,
        TransactionVoucherUsageRepository $transactionVoucherUsageRepository,
        TransactionVoucherReceiptRepository $transactionVoucherReceiptRepository,
        RecipientRepository $recipientRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->transactionVoucherUsageRepository = $transactionVoucherUsageRepository;
        $this->transactionVoucherReceiptRepository = $transactionVoucherReceiptRepository;
        $this->recipientRepository = $recipientRepository;
    }

    public function claim(array $data)
    {
        $validator = Validator::make($data, [
            'voucher_id' => 'required|integer',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $voucher = $this->voucherRepository->findById($validatedData['voucher_id']);
        $recipient = $this->recipientRepository->findByEmail($validatedData['email']);

        if (!$recipient) {
            throw new \Exception('Voucher Recipient not found');
        }

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

        $voucherRecipt = $this->transactionVoucherReceiptRepository->findByVoucherIdRecipientId($voucher->id, $recipient->id);

        if (!$voucherRecipt) {
            throw new \Exception('Voucher already claimed by this recipient');
        }

        DB::beginTransaction();
        try {
            $validatedData['keterangan_pemakaian'] = $recipient->no_wa . ' - ' . $recipient->email . ' - ' . $recipient->nama;
            $validatedData['tanggal_pemakaian'] = now();

            $this->transactionVoucherUsageRepository->create($validatedData);
            $this->transactionVoucherReceiptRepository->delete($voucherRecipt);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
