<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MVoucherType extends Model
{
    protected $table = 'm_voucher_types';

    protected $fillable = [
        'nama',
    ];
}
