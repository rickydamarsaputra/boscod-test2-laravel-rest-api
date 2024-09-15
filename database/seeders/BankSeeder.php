<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'nama_bank' => 'BNI',
                'kode_bank' => 'bni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bank' => 'BCA',
                'kode_bank' => 'bca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bank' => 'Mandiri',
                'kode_bank' => 'mandiri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Bank::insert($banks);
    }
}
