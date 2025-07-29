<?php

namespace Database\Seeders;

use App\Models\MVoucherType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MVoucherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'nama' => 'Gratis Ongkir'
            ],
            [
                'nama' => '12.12'
            ]
        ];

        foreach ($datas as $data) {
            MVoucherType::create($data);
        }
    }
}
