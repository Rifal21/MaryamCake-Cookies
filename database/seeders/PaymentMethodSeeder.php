<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'DANA',
                'account_name' => 'Maryam Cake Admin',
                'account_number' => '081234567890',
                'instructions' => 'Silakan transfer sesuai total tagihan ke nomor DANA di atas. Jangan lupa kirim bukti transfer.',
                'is_active' => true,
                'admin_fee' => 1000,
            ],
            [
                'name' => 'SeaBank',
                'account_name' => 'Maryam Cake Store',
                'account_number' => '901234567890',
                'instructions' => 'Transfer ke rekening SeaBank. Verifikasi otomatis akan diproses setelah bukti dikirim.',
                'is_active' => true,
                'admin_fee' => 0,
            ],
            [
                'name' => 'BNI',
                'account_name' => 'Maryam Cake Store',
                'account_number' => '1234567890',
                'instructions' => 'Transfer bank antar BNI atau bank lain. Gunakan kode bank 009 jika dari bank lain.',
                'is_active' => true,
                'admin_fee' => 2500,
            ],
            [
                'name' => 'COD',
                'account_name' => null,
                'account_number' => null,
                'instructions' => 'Bayar langsung tunai saat kurir mengantarkan kue ke alamat Anda.',
                'is_active' => true,
                'admin_fee' => 5000,
            ],
        ];

        foreach ($methods as $method) {
            \App\Models\PaymentMethod::updateOrCreate(['name' => $method['name']], $method);
        }
    }
}
