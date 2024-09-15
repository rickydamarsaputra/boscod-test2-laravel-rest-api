<?php

namespace Database\Seeders;

use App\Models\RekeningAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rekening_admins = [
            [
                'bank_id' => 1,
                'nomor_rekening' => '123456789012345',
                'nama_pemilik' => 'admin boscod 1 BNI',
                'saldo' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 2,
                'nomor_rekening' => '543210987654321',
                'nama_pemilik' => 'admin boscod 2 BCA',
                'saldo' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        RekeningAdmin::insert($rekening_admins);
    }
}
