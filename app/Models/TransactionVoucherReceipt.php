<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionVoucherReceipt extends Model
{
    protected $table = 'transaction_voucher_receipts';

    protected $fillable = [
        'voucher_id',
        'recipient_id',
        'tanggal_penerimaan',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }
}
