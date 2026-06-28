<?php

namespace App\Http\Controllers;

use App\Models\model_hasil_lab;
use Illuminate\Http\Request;
use App\Models\model_ts_antrian;
use App\Models\model_ts_kunjungan;
use App\Models\model_ts_layanan_detail;
use App\Models\model_ts_layanan_header;
use App\Models\model_ts_resep_detail;
use App\Models\model_ts_resep_header;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class poliklinikController extends Controller
{
    public function indexdatapasienpoli()
    {
        $menu_sub = 'indexdatapasienpoli';
        $menu = 'indexdatapasienpoli';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Poliklinik.indexdatapasienpoli', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function ambildatapasien(Request $request)
    {
        $tanggalawal = $request->tanggalawal;
        $tanggalakhir = $request->tanggalakhir;
        $data = db::select('select a.*,b.nomor_antrian,d.nama_pasien,c.nama_unit,e.nama_lengkap as nama_dokter from ts_kunjungan a 
        left join ts_antrian_pasien b on a.id = b.id_kunjungan 
        left join master_unit c on a.unit_tujuan = c.id 
        left join master_pasien d on a.nomor_rm = d.nomor_rm
        left join master_pegawai e on a.dokter = e.id        
        where date(tgl_masuk) between ?  and ? and unit_tujuan != ? and a.status_kunjungan != ?', [$tanggalawal, $tanggalakhir, 5, 3]);
        return view('Poliklinik.tabel_data_pasien', compact([
            'data'
        ]));
    }
    public function ambilformerm(Request $request)
    {
        $dk = db::select('select * from ts_kunjungan where id = ?', [$request->idkunjungan]);
        $nomor_rm = $dk[0]->nomor_rm;
        $idkunjungan = $request->idkunjungan;
        $mt_pasien = db::select('select * from master_pasien where nomor_rm = ?', [$nomor_rm]);
        $data_kunjungan = DB::table('ts_kunjungan as k')
            ->leftJoin('master_pegawai as p', 'k.dokter', '=', 'p.id')
            ->leftJoin('master_unit as u', 'k.unit_tujuan', '=', 'u.id')
            ->select('k.*', 'p.nama_lengkap as nama_dokter', 'u.nama_unit')
            ->where('k.nomor_rm', $nomor_rm)
            ->orderBy('k.id', 'desc')
            ->get();
        $tarif = db::select('select * from master_tarif_pelayanan');
        $mt_barang = db::select('select * from mt_barang where stok_global > 0');
        return view('Poliklinik.form_erm_poliklinik', compact([
            'mt_pasien',
            'data_kunjungan',
            'dk',
            'tarif',
            'idkunjungan',
            'mt_barang'
        ]));
    }
    public function simpancatatanmedis(Request $request)
    {
        // $no_resep = $this->generateNoResep();
        $data1 = json_decode($_POST['data1'], true);
        $data2 = json_decode($_POST['data2'], true);
        $data3 = json_decode($_POST['data3'], true);
        foreach ($data1 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        foreach ($data2 as $nama2) {
            $index2 = $nama2['name'];
            $value2 = $nama2['value'];
            $dataSet2[$index2] = $value2;
            if ($index2 == 'harga') {
                $arraytarif[] = $dataSet2;
            }
        }
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'status_paket') {
                $arrayobat[] = $dataSet3;
            }
        }
        $dataup = [
            'SUBJECT' => $dataSet['subject'],
            'OBJECT' => $dataSet['object'],
            'ASSESMENT' => $dataSet['assesmen'],
            'PLANNING' => $dataSet['planning'],
            'status_periksa' => 2
        ];
        model_ts_kunjungan::where('id', $dataSet['idkunjungan'])->update($dataup);
        model_ts_antrian::where('id_kunjungan', $dataSet['idkunjungan'])->update(['status' => 3]);
        if (count($data2) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
            $KODE = $this->generateKodeLayanan();
            $data_header = [
                'id_kunjungan' => $dataSet['idkunjungan'],
                'kode_layanan_header' => $KODE,
                'total_tagihan' => 0,
                'tgl_layanan' => $datenow,
                'tgl_entry' => $datenow,
                'pic' => auth()->user()->id,
                'status_bayar' => '0',
                'status_layanan' => '3'
            ];
            $h = model_ts_layanan_header::create($data_header);
            $total_tagihan = 0;
            foreach ($arraytarif as $t) {
                $data_detail = [
                    'id_header' => $h->id,
                    'id_tarif' => $t['idtarif'],
                    'nama_tarif' => $t['namatarif'],
                    'harga_satuan' => $t['harga2'],
                    'jumlah' => 1,
                    'subtotal' => $t['harga2'],
                    'status_layanan' => 1,
                ];
                model_ts_layanan_detail::create($data_detail);
                $total_tagihan = $total_tagihan + $t['harga2'];
            }
            model_ts_layanan_header::where('id', $h->id)->update(['total_tagihan' => $total_tagihan, 'status_layanan' => 1]);
        }
        if (count($data3) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
            $data_kunjungan = db::select('select * from ts_kunjungan where id = ?', [$dataSet['idkunjungan']]);
            // $dataheader = [
            //     'no_resep' => $no_resep,
            //     'id_kunjungan' => $dataSet['idkunjungan'],
            //     'no_rm' => $data_kunjungan[0]->nomor_rm,
            //     'dokter' => $data_kunjungan[0]->dokter,
            //     'unit_kirim' => $data_kunjungan[0]->unit_tujuan,
            //     'tgl_resep' => $datenow,
            //     'status_resep' => '1'
            // ];
            // $rh = model_ts_resep_header::create($dataheader);
            $datenow = Carbon::now()->format('Y-m-d');
            $KODE = $this->generateKodeLayanan();
            $idkunjungan = $dataSet['idkunjungan'];
            $data_header = [
                'id_kunjungan' => $idkunjungan,
                'kode_layanan_header' => $KODE,
                'total_tagihan' => 0,
                'tgl_layanan' => $datenow,
                'tgl_entry' => $datenow,
                'pic' => auth()->user()->id,
                'status_bayar' => '0',
                'status_layanan' => '3',
                'keterangan' => 'OBAT'
            ];
            $h = model_ts_layanan_header::create($data_header);
            $total_tagihan = 0;
            // foreach ($arrayobat as $b) {
            //     if (data_get($b, 'is_paket', 0)) {
            //         $paket = 1;
            //     } else {
            //         $paket = 0;
            //     }
            //     $mt_barang = db::select('select nama_barang,harga_jual,isi_konversi FROM mt_barang where kode_barang = ?', [$b['kodebarang']]);
            //     if ($paket == 1) {
            //         $harga = 0;
            //         $status_paket = 'YA';
            //     } else {
            //         $harga = $mt_barang[0]->harga_jual;
            //         $status_paket = 'TIDAK';
            //     }
            //     $data_detail = [
            //         'id_header' => $h->id,
            //         'kode_barang' => $b['kodebarang'],
            //         'nama_tarif' => $mt_barang[0]->nama_barang,
            //         'harga_satuan' => $harga,
            //         'jumlah' => $b['qty'],
            //         'subtotal' => $harga * $b['qty'],
            //         'status_layanan' => 1,
            //         'aturan_pakai' => $b['aturanpakai'],
            //         'status_paket' => $status_paket
            //     ];
            //     $subtotal = $harga * $b['qty'];
            //     model_ts_layanan_detail::create($data_detail);
            //     $total_tagihan = $total_tagihan + $subtotal;
            // }
            foreach ($arrayobat as $b) {
                // 1. Tentukan status paket
                $paket = data_get($b, 'is_paket', 0) ? 1 : 0;

                // 2. Ambil data master barang
                $mt_barang = DB::select('select id, nama_barang, harga_jual, isi_konversi, stok_global FROM mt_barang where kode_barang = ?', [$b['kodebarang']]);

                if (empty($mt_barang)) {
                    continue; // Lewati jika kode barang tidak ditemukan di master
                }

                $barangMaster = $mt_barang[0];

                if ($paket == 1) {
                    $harga = 0;
                    $status_paket = 'YA';
                } else {
                    $harga = $barangMaster->harga_jual;
                    $status_paket = 'TIDAK';
                }

                $subtotal = $harga * $b['qty'];

                // 3. Insert ke detail layanan pasien
                $data_detail = [
                    'id_header'       => $h->id,
                    'kode_barang'     => $b['kodebarang'],
                    'nama_tarif'      => $barangMaster->nama_barang,
                    'harga_satuan'    => $harga,
                    'jumlah'          => $b['qty'],
                    'subtotal'        => $subtotal,
                    'status_layanan'  => 1,
                    'aturan_pakai'    => $b['aturanpakai'],
                    'status_paket'    => $status_paket
                ];
                $ts_layanan_detail = model_ts_layanan_detail::create($data_detail);
                $total_tagihan = $total_tagihan + $subtotal;

                // =========================================================================
                // PROSES PENGURANGAN STOK GUDANG & LOG BATCH (FIFO BY EXPIRED DATE CLOSEST)
                // =========================================================================

                $jumlahDibutuhkan = (int) $b['qty'];

                // Ambil semua batch sediaan yang masih ada stoknya, urutkan dari ED terdekat (FIFO)
                $daftarSediaan = DB::table('mt_stok_persediaan_barang')
                    ->where('kode_barang', $b['kodebarang'])
                    ->where('stok_sekarang', '>', 0)
                    ->orderBy('tanggal_kadaluwarsa', 'asc') // Urutan ED Terdekat
                    ->orderBy('id', 'asc')
                    ->get();

                // Catat saldo awal global barang untuk keperluan log kartu stok
                $stokAwalGlobal = (int) $barangMaster->stok_global;

                foreach ($daftarSediaan as $sediaan) {
                    if ($jumlahDibutuhkan <= 0) {
                        break; // Jika kebutuhan obat sudah terpenuhi dari batch sebelumnya, hentikan loop batch
                    }

                    $stokTerbuka = (int) $sediaan->stok_sekarang;

                    // Tentukan berapa jumlah yang diambil dari batch ini
                    if ($stokTerbuka >= $jumlahDibutuhkan) {
                        // Jika stok di batch ini melimpah/cukup
                        $jumlahDiambil = $jumlahDibutuhkan;
                        $jumlahDibutuhkan = 0;
                    } else {
                        // Jika stok di batch ini kurang, ambil semua sisa yang ada, lalu lanjut cari di batch berikutnya
                        $jumlahDiambil = $stokTerbuka;
                        $jumlahDibutuhkan -= $stokTerbuka;
                    }

                    // A. Kurangi stok_sekarang di tabel sediaan batch terkait
                    DB::table('mt_stok_persediaan_barang')
                        ->where('id', $sediaan->id)
                        ->decrement('stok_sekarang', $jumlahDiambil);

                    // B. Kurangi stok_global di tabel master barang (mt_barang)
                    DB::table('mt_barang')
                        ->where('kode_barang', $b['kodebarang'])
                        ->decrement('stok_global', $jumlahDiambil);

                    // Hitung akumulasi saldo global setelah dikurangi baris ini untuk kebutuhan log kartu stok
                    $stokAkhirGlobal = $stokAwalGlobal - $jumlahDiambil;

                    // C. Catat Log Persediaan Barang (Mutasi KELUAR) per batch yang terpotong
                    DB::table('mt_log_persediaan_barang')->insert([
                        'kode_barang'     => $b['kodebarang'],
                        'no_batch'        => $sediaan->no_batch,
                        'id_persediaan'   => $sediaan->id,
                        'id_layanan_detail'   => $ts_layanan_detail->id,
                        'jenis_transaksi' => 'KELUAR',
                        'keterangan'      => 'Pengurangan Obat Pasien (Detail Layanan ID: ' . $h->id . ')',
                        'jumlah'          => $jumlahDiambil,
                        'stok_awal'       => $stokAwalGlobal,
                        'stok_akhir'      => $stokAkhirGlobal,
                        'user_id'         => auth()->id() ?? null,
                        'tanggal_log'     => now()->toDateString(),
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);

                    // Perbarui counter stok awal untuk loop batch berikutnya (jika quantity > 1 batch)
                    $stokAwalGlobal = $stokAkhirGlobal;
                }

                // [OPSIONAL] Validasi jika setelah mutasi semua batch ternyata obat masih kurang dari QTY permintaan
                if ($jumlahDibutuhkan > 0) {
                    // Anda bisa melempar exception atau membiarkannya minus tergantung kebijakan aplikasi SIMRS Anda
                    // throw new \Exception("Stok obat untuk kode " . $b['kodebarang'] . " kurang dari permintaan.");
                }
            }
            model_ts_layanan_header::where('id', $h->id)->update(['total_tagihan' => $total_tagihan, 'status_layanan' => 1]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilriwayatbilling(Request $request)
    {
        $id = $request->idkunjungan;
        $layanan = DB::table('ts_layanan_header as a')
            ->join('ts_layanan_detail as b', 'b.id_header', '=', 'a.id')
            ->select(
                'b.*',
                'a.*',
                'b.id as iddetail'
            )
            ->where('a.id_kunjungan', $id)
            ->where('b.status_layanan', 1)
            ->get();
        return view('Poliklinik.tabel_riwayat_billing', compact([
            'layanan'
        ]));
    }
    public function ambilriwayatresep(Request $request)
    {
        $id = $request->idkunjungan;
        $data = DB::table('ts_resep_header as a')
            ->select(
                'a.no_resep',
                'a.tgl_resep',
                'a.no_rm',
                'b.kode_barang',
                'b.qty',
                'b.id as iddetail',
                'c.nama_barang',
                'c.satuan_kecil',
                'c.aturan_pakai',
                'a.status_resep',
                'b.status_obat'
            )
            ->join('ts_resep_detail as b', 'a.id', '=', 'b.id_header')
            ->join('master_barang as c', 'b.kode_barang', '=', 'c.kode_barang')
            // Jika ingin spesifik untuk satu kunjungan
            ->where('a.id_kunjungan', $id)
            ->get();
        return view('Poliklinik.tabel_riwayat_resep', compact([
            'data'
        ]));
    }
    public function generateKodeLayanan()
    {
        $prefix = "LYN";
        $today = Carbon::now()->format('Ymd'); // Hasil: 20260224

        // 1. Cari kode terakhir yang dibuat hari ini
        $lastKode = DB::table('ts_layanan_header')
            ->where('kode_layanan_header', 'LIKE', $prefix . '-' . $today . '-%')
            ->orderBy('kode_layanan_header', 'desc')
            ->first();

        if ($lastKode) {
            // Ambil 4 digit terakhir (nomor urut), lalu tambah 1
            $lastNum = substr($lastKode->kode_layanan_header, -4);
            $nextNum = str_pad((int)$lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada transaksi hari ini, mulai dari 0001
            $nextNum = '0001';
        }

        $newKode = $prefix . '-' . $today . '-' . $nextNum;

        return $newKode; // Hasil: LYN-20260224-0001
    }
    public function generateNoResep()
    {
        $today = date('Ymd'); // Hasil: 20260225
        $prefix = 'RSP-' . $today . '-';

        // Cari no_resep terakhir yang dibuat hari ini
        $lastResep = DB::table('ts_resep_header')
            ->where('no_resep', 'LIKE', $prefix . '%')
            ->orderBy('no_resep', 'desc')
            ->first();

        if (!$lastResep) {
            // Jika belum ada resep hari ini, mulai dari 0001
            return $prefix . '0001';
        }

        // Ambil 4 digit terakhir, ubah ke integer, tambah 1
        $lastNumber = (int) substr($lastResep->no_resep, -4);
        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $nextNumber;
    }
    public function ambilhasillab(Request $request)
    {
        $kode_kunjungan = $request->idkunjungan;
        $hasillab = model_hasil_lab::where('kode_kunjungan', $kode_kunjungan)->first();
        return view('Poliklinik.hasillab', compact([
            'hasillab'
        ]));
    }
    public function cekKesiapanCetak(Request $request)
    {
        $kode = $request->kode_kunjungan;

        // Cek apakah data lab untuk kunjungan ini memang ada di DB
        $cek = model_hasil_lab::where('kode_kunjungan', $kode)->first();

        if (!$cek) {
            return response()->json([
                'kode' => 404,
                'status' => 'error',
                'message' => 'Gagal cetak! Parameter hasil lab untuk kunjungan ini belum diisi.'
            ]);
        }

        // Jika ada, kirim status sukses beserta link URL cetak dokumennya
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'url_cetak' => url('cetak_nota_laboratorium/' . $kode) // Route halaman cetak PDF
        ]);
    }
}
