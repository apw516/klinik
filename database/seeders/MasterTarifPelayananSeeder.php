<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterTarifPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $data = [
            ['nama_tarif' => '+Obat 4A', 'tarif_1' => 70000, 'tarif_2' => 70000, 'tarif_3' => 70000],
            ['nama_tarif' => '+Obat 3A+B', 'tarif_1' => 75000, 'tarif_2' => 75000, 'tarif_3' => 75000],
            ['nama_tarif' => '+Obat 5A', 'tarif_1' => 75000, 'tarif_2' => 75000, 'tarif_3' => 75000],
            ['nama_tarif' => '+Obat 6A', 'tarif_1' => 80000, 'tarif_2' => 80000, 'tarif_3' => 80000],
            ['nama_tarif' => '+Obat 7A', 'tarif_1' => 85000, 'tarif_2' => 85000, 'tarif_3' => 85000],
            ['nama_tarif' => '+Obat 3A+2B', 'tarif_1' => 85000, 'tarif_2' => 85000, 'tarif_3' => 85000],
            ['nama_tarif' => '+Obat 4A+2B', 'tarif_1' => 90000, 'tarif_2' => 90000, 'tarif_3' => 90000],
            ['nama_tarif' => 'Tebus Obat A (Maks 4 jenis)', 'tarif_1' => 15000, 'tarif_2' => 15000, 'tarif_3' => 15000],
            ['nama_tarif' => 'Tebus Obat B (Maks 4 jenis)', 'tarif_1' => 20000, 'tarif_2' => 20000, 'tarif_3' => 20000],
            ['nama_tarif' => 'Nebu', 'tarif_1' => 75000, 'tarif_2' => 75000, 'tarif_3' => 75000],
            ['nama_tarif' => 'Suntik IM', 'tarif_1' => 15000, 'tarif_2' => 15000, 'tarif_3' => 15000],
            ['nama_tarif' => 'Suntik IV', 'tarif_1' => 25000, 'tarif_2' => 25000, 'tarif_3' => 25000],
            ['nama_tarif' => 'Suntik GO IM', 'tarif_1' => 400000, 'tarif_2' => 400000, 'tarif_3' => 400000],
            ['nama_tarif' => 'Suntik ATS', 'tarif_1' => 250000, 'tarif_2' => 250000, 'tarif_3' => 250000],
            ['nama_tarif' => 'Suntik KB', 'tarif_1' => 40000, 'tarif_2' => 40000, 'tarif_3' => 40000],
            ['nama_tarif' => 'Debridement luka 1', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'Debridement luka 2', 'tarif_1' => 75000, 'tarif_2' => 75000, 'tarif_3' => 75000],
            ['nama_tarif' => 'Debridement luka 3', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Hecting 1-3', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Hecting 4-6', 'tarif_1' => 150000, 'tarif_2' => 150000, 'tarif_3' => 150000],
            ['nama_tarif' => 'Hecting 7-9', 'tarif_1' => 200000, 'tarif_2' => 200000, 'tarif_3' => 200000],
            ['nama_tarif' => 'Ektraksi Corpal Mata', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Ektraksi Corpal Hidung', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Ektraksi Corpal Telinga', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Ektraksi Kuku', 'tarif_1' => 150000, 'tarif_2' => 150000, 'tarif_3' => 150000],
            ['nama_tarif' => 'Insisi Abses', 'tarif_1' => 150000, 'tarif_2' => 200000, 'tarif_3' => 200000],
            ['nama_tarif' => 'Insisi Tumor/Clavus', 'tarif_1' => 200000, 'tarif_2' => 250000, 'tarif_3' => 250000],
            ['nama_tarif' => 'Debridement Abses', 'tarif_1' => 150000, 'tarif_2' => 150000, 'tarif_3' => 150000],
            ['nama_tarif' => 'Infus Mudah', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Infus Sulit', 'tarif_1' => 150000, 'tarif_2' => 150000, 'tarif_3' => 150000],
            ['nama_tarif' => 'Seperangkat Infus', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Suntik IV A', 'tarif_1' => 30000, 'tarif_2' => 30000, 'tarif_3' => 30000],
            ['nama_tarif' => 'Suntik IV B', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'Kamar', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Pasang DC', 'tarif_1' => 120000, 'tarif_2' => 120000, 'tarif_3' => 120000],
            ['nama_tarif' => 'Aff DC', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'USG Cetak', 'tarif_1' => 80000, 'tarif_2' => 80000, 'tarif_3' => 80000],
            ['nama_tarif' => 'USG Non Cetak', 'tarif_1' => 70000, 'tarif_2' => 70000, 'tarif_3' => 70000],
            ['nama_tarif' => 'Cek GDS', 'tarif_1' => 20000, 'tarif_2' => 20000, 'tarif_3' => 20000],
            ['nama_tarif' => 'Cek Cholesterol', 'tarif_1' => 25000, 'tarif_2' => 25000, 'tarif_3' => 25000],
            ['nama_tarif' => 'Cek Asam Urat', 'tarif_1' => 20000, 'tarif_2' => 20000, 'tarif_3' => 20000],
            ['nama_tarif' => 'Cek Hb', 'tarif_1' => 35000, 'tarif_2' => 35000, 'tarif_3' => 35000],
            ['nama_tarif' => 'Cek Darah Rutin', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Cek Widal', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
            ['nama_tarif' => 'Cek HIV', 'tarif_1' => 350000, 'tarif_2' => 350000, 'tarif_3' => 350000],
            ['nama_tarif' => 'Cek HbSAg', 'tarif_1' => 250000, 'tarif_2' => 250000, 'tarif_3' => 250000],
            ['nama_tarif' => 'Cek Kehamilan', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'Cek Golongan Darah', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'Surat Sehat', 'tarif_1' => 40000, 'tarif_2' => 40000, 'tarif_3' => 40000],
            ['nama_tarif' => 'Periksa + rujukan', 'tarif_1' => 50000, 'tarif_2' => 50000, 'tarif_3' => 50000],
            ['nama_tarif' => 'EKG', 'tarif_1' => 100000, 'tarif_2' => 100000, 'tarif_3' => 100000],
        ];

        foreach ($data as $item) {
            DB::table('master_tarif_pelayanan')->insert([
                'id_klinik'   => 1,
                'nama_tarif'  => $item['nama_tarif'],
                'jenis_tarif' => 'RAWAT JALAN',
                'tarif_1'     => $item['tarif_1'],
                'tarif_2'     => $item['tarif_2'],
                'tarif_3'     => $item['tarif_3'],
                'status'      => 1,
                'pic'         => 1,
                'tgl_entry'   => $now,
            ]);
        }
    }
}