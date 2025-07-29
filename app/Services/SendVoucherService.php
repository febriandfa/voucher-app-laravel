<?php

namespace App\Services;

use App\Mail\SendVoucherMail;
use App\Repositories\RecipientRepository;
use App\Repositories\TransactionVoucherReceiptRepository;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendVoucherService
{
    /**
     * Create a new class instance.
     */

    protected $voucherRepository;
    protected $recipientRepository;
    protected $transactionVoucherReceiptRepository;

    public function __construct(
        VoucherRepository $voucherRepository,
        RecipientRepository $recipientRepository,
        TransactionVoucherReceiptRepository $transactionVoucherReceiptRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->recipientRepository = $recipientRepository;
        $this->transactionVoucherReceiptRepository = $transactionVoucherReceiptRepository;
    }

    public function send(array $data)
    {
        $validator = Validator::make($data, [
            'voucher_id' => 'required|integer|exists:vouchers,id',
            'send_type' => 'required|in:all,random',
            'total' => 'required_if:send_type,random|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        if ($validatedData['send_type'] == 'random') {
            if (!isset($validatedData['total']) || $validatedData['total'] <= 0) {
                throw new \Exception('Total must be greater than 0 for random send type.');
            }

            return $this->sendToRandomRecipient($validatedData['voucher_id'], $validatedData['total']);
        } elseif ($validatedData['send_type'] == 'all') {
            return $this->sendToAllRecipients($validatedData['voucher_id']);
        }
    }

    private function sendToRandomRecipient($voucherId, $total)
    {
        $recipients = $this->recipientRepository->getRandom($total);
        $voucher = $this->voucherRepository->findById($voucherId);
        foreach ($recipients as $recipient) {
            $this->transactionVoucherReceiptRepository->create([
                'voucher_id' => $voucherId,
                'recipient_id' => $recipient->id,
                'tanggal_penerimaan' => now(),
            ]);

            Mail::to($recipient->email)->send(new SendVoucherMail(
                $voucher,
                $recipient
            ));
        }

        return true;
    }

    private function sendToAllRecipients($voucherId)
    {
        $recipients = $this->recipientRepository->getAll();
        $voucher = $this->voucherRepository->findById($voucherId);
        foreach ($recipients as $recipient) {
            $this->transactionVoucherReceiptRepository->create([
                'voucher_id' => $voucherId,
                'recipient_id' => $recipient->id,
                'tanggal_penerimaan' => now(),
            ]);

            Mail::to($recipient->email)->send(new SendVoucherMail(
                $voucher,
                $recipient
            ));
        }

        return true;
    }
}
