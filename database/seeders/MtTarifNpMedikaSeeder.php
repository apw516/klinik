<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MtTarifNpMedikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tarif = [
            ['nama_tarif' => 'Pemeriksaan Dokter', 'harga' => 30000],
            ['nama_tarif' => 'Pemeriksaan Dokter Malam', 'harga' => 45000],
            ['nama_tarif' => 'Konsultasi', 'harga' => 50000],
            ['nama_tarif' => 'SKD', 'harga' => 10000],
            ['nama_tarif' => 'Kwitansi', 'harga' => 5000],
            ['nama_tarif' => 'Tindakan IGD Malam', 'harga' => 50000],
            ['nama_tarif' => '+Obat 4A', 'harga' => 70000],
            ['nama_tarif' => '+Obat 3A+B', 'harga' => 75000],
            ['nama_tarif' => '+Obat 5A', 'harga' => 75000],
            ['nama_tarif' => '+Obat 6A', 'harga' => 80000],
            ['nama_tarif' => '+Obat 7A', 'harga' => 85000],
            ['nama_tarif' => '+Obat 3A+2B', 'harga' => 85000],
            ['nama_tarif' => '+Obat 4A+2B', 'harga' => 90000],
            ['nama_tarif' => 'Resep Dokter, maks 3 Obat', 'harga' => 5000],
            ['nama_tarif' => 'Tebus Obat A (Maks 4 jenis)', 'harga' => 15000],
            ['nama_tarif' => 'Tebus Obat B (Maks 4 jenis)', 'harga' => 20000],
            ['nama_tarif' => 'Tebus Obat A >4', 'harga' => 10000],
            ['nama_tarif' => 'Tebus Obat B >4', 'harga' => 15000],
            ['nama_tarif' => 'Nebu', 'harga' => 75000],
            ['nama_tarif' => 'Suntik IM RAJAL', 'harga' => 15000],
            ['nama_tarif' => 'Suntik IM IGD', 'harga' => 20000],
            ['nama_tarif' => 'Suntik IV RAJAL', 'harga' => 25000],
            ['nama_tarif' => 'Suntik IM IGD', 'harga' => 30000],
            ['nama_tarif' => 'Suntik GO IM', 'harga' => 400000],
            ['nama_tarif' => 'Suntik ATS', 'harga' => 250000],
            ['nama_tarif' => 'Suntik KB', 'harga' => 40000],
            ['nama_tarif' => 'Luka KLL Kassa 1-3', 'harga' => 50000],
            ['nama_tarif' => 'Luka KLL Kassa 4-6', 'harga' => 75000],
            ['nama_tarif' => 'Luka KLL Kassa 7-9', 'harga' => 100000],
            ['nama_tarif' => 'Luka KLL Kassa 10-12', 'harga' => 125000],
            ['nama_tarif' => 'Luka KLL Kassa 13-15', 'harga' => 150000],
            ['nama_tarif' => 'Tutup luka', 'harga' => 25000],
            ['nama_tarif' => 'Bersihkan Abses luka kecil', 'harga' => 100000],
            ['nama_tarif' => 'Bersihkan Abses luka sedang', 'harga' => 150000],
            ['nama_tarif' => 'Bersihkan Abses luka besar', 'harga' => 200000],
            ['nama_tarif' => 'Hecting 1-3', 'harga' => 100000],
            ['nama_tarif' => 'Hecting 4-6', 'harga' => 150000],
            ['nama_tarif' => 'Hecting 7-9', 'harga' => 200000],
            ['nama_tarif' => 'Ektraksi Corpal Mata', 'harga' => 100000],
            ['nama_tarif' => 'Ektraksi Corpal Hidung', 'harga' => 100000],
            ['nama_tarif' => 'Ektraksi Corpal Telinga', 'harga' => 100000],
            ['nama_tarif' => 'Ektraksi Kuku', 'harga' => 150000],
            ['nama_tarif' => 'Insisi Abses Kecil', 'harga' => 150000],
            ['nama_tarif' => 'Insisi Abses Besar', 'harga' => 200000],
            ['nama_tarif' => 'Insisi Tumor/Clavus Kecil', 'harga' => 200000],
            ['nama_tarif' => 'Insisi Tumor/Clavus Besar', 'harga' => 250000],
            ['nama_tarif' => 'Infus Mudah', 'harga' => 100000],
            ['nama_tarif' => 'Infus Sulit', 'harga' => 150000],
            ['nama_tarif' => 'Infus Set', 'harga' => 100000],
            ['nama_tarif' => 'Suntik IV A', 'harga' => 30000],
            ['nama_tarif' => 'Suntik IV B', 'harga' => 50000],
            ['nama_tarif' => 'Kamar', 'harga' => 100000],
            ['nama_tarif' => 'Pasang DC', 'harga' => 150000],
            ['nama_tarif' => 'Aff DC', 'harga' => 50000],
            ['nama_tarif' => 'Lepas Pasang DC', 'harga' => 175000],
            ['nama_tarif' => 'USG Cetak', 'harga' => 80000],
            ['nama_tarif' => 'USG Non Cetak', 'harga' => 70000],
            ['nama_tarif' => 'Cek GDS', 'harga' => 20000],
            ['nama_tarif' => 'Cek Cholesterol', 'harga' => 25000],
            ['nama_tarif' => 'Cek Asam Urat', 'harga' => 20000],
            ['nama_tarif' => 'Cek Hb', 'harga' => 35000],
            ['nama_tarif' => 'Cek Darah Rutin', 'harga' => 100000],
            ['nama_tarif' => 'Cek Widal', 'harga' => 100000],
            ['nama_tarif' => 'Cek HIV', 'harga' => 350000],
            ['nama_tarif' => 'Cek HbSAg', 'harga' => 150000],
            ['nama_tarif' => 'Cek Kehamilan', 'harga' => 50000],
            ['nama_tarif' => 'Cek Golongan Darah', 'harga' => 50000],
            ['nama_tarif' => 'Surat Sehat', 'harga' => 45000],
            ['nama_tarif' => 'Periksa + rujukan', 'harga' => 50000],
            ['nama_tarif' => 'EKG', 'harga' => 100000],
        ];

        DB::table('mt_tarif_np_medika')->insert($tarif);
    }
}
