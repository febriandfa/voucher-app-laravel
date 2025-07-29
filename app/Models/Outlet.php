<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlets';

    protected $fillable = [
        'nama',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'outlet_id', 'id');
    }
}
