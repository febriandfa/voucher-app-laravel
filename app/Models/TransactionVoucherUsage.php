<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionVoucherUsage extends Model
{
    protected $table = 'transaction_voucher_usages';

    protected $fillable = [
        'voucher_id',
        'keterangan_pemakaian',
        'tanggal_pemakaian',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
