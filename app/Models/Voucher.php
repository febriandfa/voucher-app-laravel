<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'outlet_id',
        'm_voucher_type_id',
        'deskripsi',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'status',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function mVoucherType()
    {
        return $this->belongsTo(MVoucherType::class, 'm_voucher_type_id');
    }

    public function transactionVoucherReceipts()
    {
        return $this->hasMany(TransactionVoucherReceipt::class, 'voucher_id');
    }
}
