<?php

namespace Database\Seeders;

use App\Models\Recipient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =[
            [
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'no_wa' => '08123456789',
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane@example.com',
                'no_wa' => '08113456789',
            ],
            [
                'nama' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'no_wa' => '08223456789',
            ]
        ];

        foreach ($datas as $data) {
            Recipient::create($data);
        }
    }
}
