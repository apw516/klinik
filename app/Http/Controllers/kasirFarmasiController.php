<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\model_ts_antrian;
use App\Models\model_ts_kunjungan;
use App\Models\model_ts_layanan_detail;
use App\Models\model_ts_layanan_header;
use App\Models\model_ts_resep_detail;
use App\Models\model_ts_resep_header;
use App\Models\model_ts_transaksi_kasir_detail;
use App\Models\model_ts_transaksi_kasir_header;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class kasirFarmasiController extends Controller
{
    public function indexdatapasienkasirfarmasi()
    {
        $menu_sub = 'indexdatapasienkasirfarmasi';
        $menu = 'indexdatapasienkasirfarmasi';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Kasirfarmasi.indexdatapasien', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function indexkartustokobat()
    {
        $menu_sub = 'indexkartustokobat';
        $menu = 'indexkartustokobat';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Kasirfarmasi.indexkartustokobat', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function indexlogtransaksikasir()
    {
        $menu_sub = 'indexlogtransaksikasir';
        $menu = 'indexlogtransaksikasir';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Kasirfarmasi.indexlogtransaksikasir', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function indexriwayattagihan()
    {
        $menu_sub = 'indexriwayatpembayaran';
        $menu = 'indexriwayatpembayaran';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Kasirfarmasi.indexriwayattagihan', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function ambildatapasienkasirfarmasi(Request $request)
    {
        $tanggalawal = $request->tanggalawal;
        $tanggalakhir = $request->tanggalakhir;
        $data = DB::table('ts_layanan_header as a')
            ->select(
                'a.id_kunjungan',
                'b.tgl_masuk',
                'b.nomor_rm',
                'b.unit_tujuan',
                'b.jenis_kunjungan',
                'b.dokter',
                'c.nama_pasien',
                'd.nama_lengkap as nama_dokter',
                'e.nama_unit',
                // 1. Total Semua Layanan (Kecuali Retur/Status 3)
                DB::raw("COUNT(CASE WHEN a.status_layanan != 3 THEN a.id END) as total_layanan_header"),

                // 2. Kolom Baru: Jumlah Layanan Belum Bayar (Hanya Status 1)
                DB::raw("COUNT(CASE WHEN a.status_layanan = 1 THEN a.id END) as jumlah_belum_bayar"),

                // 3. Tambahan: Menghitung yang sudah diproses (Status 2) jika perlu
                DB::raw("COUNT(CASE WHEN a.status_layanan = 2 THEN a.id END) as jumlah_sudah_bayar"),
                // Menghitung jumlah header layanan dalam satu kunjungan
                DB::raw('COUNT(a.id) as jumlah_layanan_header'),
                // Mengambil contoh tgl_layanan terbaru atau pertama (opsional)
                DB::raw('MAX(a.tgl_layanan) as tgl_layanan_terakhir')
            )
            ->join('ts_kunjungan as b', 'a.id_kunjungan', '=', 'b.id')
            ->join('master_pasien as c', 'b.nomor_rm', '=', 'c.nomor_rm')
            ->leftJoin('master_pegawai as d', 'b.dokter', '=', 'd.id')
            ->leftJoin('master_unit as e', 'b.unit_tujuan', '=', 'e.id')
            ->whereBetween('a.tgl_layanan', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->where('a.status_layanan', '!=', 3)
            // Kelompokkan berdasarkan data kunjungan agar tidak duplikat
            ->groupBy(
                'a.id_kunjungan',
                'b.id',
                'b.tgl_masuk',
                'b.nomor_rm',
                'b.unit_tujuan',
                'b.jenis_kunjungan',
                'b.dokter',
                'c.nama_pasien',
                'd.nama_lengkap',
                'e.nama_unit'
            )
            ->get();
        return view('Kasirfarmasi.tabel_data_pasien', compact([
            'data'
        ]));
    }
    public function ambillogtransaksikasir(Request $request)
    {
        $tanggalAwal = $request->tanggalawal . ' 00:00:00';
        $tanggalAkhir = $request->tanggalakhir . ' 23:59:59';
        $data = DB::table('ts_transaksi_kasir_header as a')
            ->select(
                'a.id_transaksi',
                'a.id as idtx',
                'a.tgl_transaksi',
                'a.total_bruto',
                'a.total_neto',
                'a.bayar',
                'a.kembalian',
                'a.total_diskon',
                'b.id as id_kunjungan',
                'b.tgl_masuk',
                'c.nomor_rm',
                'c.nama_pasien',
            )
            ->join('ts_kunjungan as b', 'a.id_kunjungan', '=', 'b.id')
            ->join('master_pasien as c', 'b.nomor_rm', '=', 'c.nomor_rm')
            ->where('a.status', 1)
            ->whereBetween('a.tgl_transaksi', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('a.tgl_transaksi', 'desc')
            ->get();
        return view('Kasirfarmasi.tabel_log_transaksi', compact([
            'data'
        ]));
    }
    public function ambilriwayattagihanpasien(Request $request)
    {
        $tanggalAwal = $request->tanggalawal . ' 00:00:00';
        $tanggalAkhir = $request->tanggalakhir . ' 23:59:59';

        $data = DB::table('ts_kunjungan as a')
            ->select(
                'a.id as id_kunjungan',
                'a.tgl_masuk',
                'a.nomor_rm',
                'b.nama_pasien',
                'c.nama_unit',
                'd.kode_layanan_header',
                'd.tgl_layanan',
                'd.status_layanan',
                'd.status_bayar',
                'd.total_tagihan'
            )
            ->join('master_pasien as b', 'a.nomor_rm', '=', 'b.nomor_rm')
            ->join('master_unit as c', 'a.unit_tujuan', '=', 'c.id')
            ->leftJoin('ts_layanan_header as d', 'a.id', '=', 'd.id_kunjungan') // Gunakan leftJoin jika ingin tetap menampilkan kunjungan tanpa layanan
            ->whereBetween('a.tgl_masuk', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('a.tgl_masuk', 'desc')
            ->get();
        return view('Kasirfarmasi.tabel_riwayat_tagihan', compact([
            'data'
        ]));
    }
    public function ambilformpembayarankasir(Request $request)
    {
        $idlayananheader = $request->idlayanan;
        $idkunjungan = $request->idkunjungan;
        return view('Kasirfarmasi.form_pembayaran', compact([
            'idlayananheader',
            'idkunjungan'
        ]));
    }
    public function returpembayaran(Request $request)
    {
        $idheader = $request->idheader;
        model_ts_transaksi_kasir_header::where('id', $idheader)->update(['status' => 2]);

        $detail = db::select('select * from ts_transaksi_kasir_detail where id_header = ?', [$idheader]);
        foreach ($detail as $dd) {
            $id_detail = $dd->id;
            $idlydt = $dd->id_layanan_detail;
            $idlyhd = $dd->id_layanan_header;
            $dataheader = [
                'status_bayar' => 0,
                'status_layanan' => 1
            ];
            model_ts_layanan_header::where('id', $idlyhd)->update($dataheader);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran berhasil dibatalkan ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function detailpembayaran(Request $request)
    {
        $id = $request->idheader;
        $idtrans = $request->idtrans;
        $data = db::select('select * from ts_transaksi_kasir_detail a left join ts_layanan_detail b on a.id_layanan_detail = b.id where a.id_header = ?', [$id]);
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'message' => 'Berhasil!',
            'view' => view('Kasirfarmasi.detail_pembayaran', compact('data','idtrans'))->render()
        ]);
    }
    public function ambildataorderresep(Request $request)
    {
        $id_kunjungan = $request->idkunjungan;
        $data = DB::select("SELECT a.*,b.*,c.nama_barang,stok_terakhir.stok_sekarang as stok_tersedia,b.id as iddetail FROM ts_resep_header a INNER JOIN ts_resep_detail b ON a.id = b.id_header INNER JOIN master_barang c ON b.kode_barang = c.kode_barang LEFT JOIN (SELECT s1.kode_barang, s1.stok_sekarang FROM ts_kartu_stok s1 WHERE s1.id IN ( SELECT MAX(id) FROM ts_kartu_stok GROUP BY kode_barang )) AS stok_terakhir ON b.kode_barang = stok_terakhir.kode_barang WHERE a.id_kunjungan = ? AND a.status_resep = 1 AND b.status_obat = 1", [$id_kunjungan]);
        return view('Kasirfarmasi.tabl_data_order', compact([
            'data'
        ]));
    }
    public function simpanpembayaran(Request $request)
    {
        // 1. Inisialisasi & Validasi Awal
        $idkunjungan = $request->idkunjungan;
        $totalbruto = $request->totaltagihanasli;
        $bayar = $request->uangbayarasli;
        $diskon = $request->diskon ?? 0;

        // Hitung Netto
        $diskontunai = ($diskon != 0) ? ($totalbruto * $diskon / 100) : 0;
        $totalNetto = $totalbruto - $diskontunai;

        // Cek Kecukupan Uang
        if ($bayar < $totalNetto) {
            return response()->json([
                'kode' => 422,
                'status' => 'error',
                'message' => 'Uang bayar tidak cukup!'
            ]);
        }

        $kembalian = $bayar - $totalNetto;
        $now = Carbon::now();

        // 2. Persiapan Data Header
        $dataheader2 = [
            'id_transaksi'  => $this->generateNoTransaksi(),
            'id_kunjungan'  => $idkunjungan,
            'tgl_transaksi' => $now,
            'total_bruto'   => $totalbruto,
            'total_diskon'  => $diskontunai,
            'total_neto'    => $totalNetto,
            'bayar'         => $bayar,
            'kembalian'     => $kembalian,
            'pic'           => auth()->user()->id,
            'tgl_entry'     => $now,
        ];

        // 3. Ambil Data Layanan & Kunjungan
        $dataLayanan = DB::select(
            '
        SELECT a.id as idheader, b.id as iddetail, b.subtotal, 
               b.kode_barang, b.id_tarif, b.jumlah 
        FROM ts_layanan_header a 
        INNER JOIN ts_layanan_detail b ON a.id = b.id_header 
        WHERE a.id_kunjungan = ? AND a.status_layanan = ? AND b.status_layanan = ?',
            [$idkunjungan, 1, 1]
        );

        if (empty($dataLayanan)) {
            return response()->json(['kode' => 404, 'status' => 'error', 'message' => 'Tidak ada layanan untuk dibayar!']);
        }

        $kunjungan = DB::table('ts_kunjungan as b')
            ->join('master_pasien as a', 'b.nomor_rm', '=', 'a.nomor_rm')
            ->where('b.id', $idkunjungan)
            ->first();

        // 4. Proses Database dengan Error Handling
        DB::beginTransaction();
        try {
            // Simpan Header Transaksi Kasir
            $header = model_ts_transaksi_kasir_header::create($dataheader2);

            foreach ($dataLayanan as $d) {
                // Simpan Detail Transaksi Kasir
                model_ts_transaksi_kasir_detail::create([
                    'id_header'         => $header->id,
                    'id_layanan_header' => $d->idheader,
                    'id_layanan_detail' => $d->iddetail,
                    'kode_barang'       => $d->kode_barang,
                    'id_tarif'          => $d->id_tarif,
                    'subtotal'          => $d->subtotal
                ]);

                // LOGIKA STOK (Jika Item adalah Barang)
                if (!empty($d->kode_barang)) {
                    $qtyDibutuhkan = $d->jumlah;

                    // Ambil batch berdasarkan Expired Date terdekat (FEFO)
                    $batches = DB::table('ts_stok_batch')
                        ->where('kode_barang', $d->kode_barang)
                        ->where('stok_now', '>', 0)
                        ->orderBy('tgl_ed', 'asc')
                        ->lockForUpdate() // Mencegah race condition stok
                        ->get();
                    foreach ($batches as $batch) {
                        if ($qtyDibutuhkan <= 0) break;

                        $jumlahDipotong = min($qtyDibutuhkan, $batch->stok_now);
                        $stokBaruBatch = $batch->stok_now - $jumlahDipotong;

                        // Update Tabel Batch
                        DB::table('ts_stok_batch')->where('id', $batch->id)->update(['stok_now' => $stokBaruBatch]);

                        // Ambil Saldo Stok Terakhir secara Global (Kartu Stok)
                        $stokTerakhirGlobal = DB::table('ts_kartu_stok')
                            ->where('kode_barang', $d->kode_barang)
                            ->orderBy('id', 'desc')
                            ->value('stok_sekarang') ?? 0;

                        // Catat ke Kartu Stok
                        DB::table('ts_kartu_stok')->insert([
                            'tgl_transaksi' => now(),
                            'kode_barang'   => $d->kode_barang,
                            'no_batch'      => $batch->no_batch,
                            'kode_unit'     => 5, // Unit Farmasi
                            'stok_masuk'    => 0,
                            'stok_keluar'   => $jumlahDipotong,
                            'stok_terakhir' => $stokTerakhirGlobal,
                            'stok_sekarang' => $stokTerakhirGlobal - $jumlahDipotong,
                            'keterangan'    => ($kunjungan->nomor_rm ?? '-') . ' | ' . ($kunjungan->nama_pasien ?? '-'),
                            'no_referensi'  => 'TRX Kasir: ' . $header->id_transaksi,
                            'pic'           => auth()->user()->id
                        ]);

                        $qtyDibutuhkan -= $jumlahDipotong;
                    }
                    // Jika setelah semua batch dicek stok masih kurang
                    if ($qtyDibutuhkan > 0) {
                        throw new \Exception("Stok barang [{$d->kode_barang}] tidak mencukupi! Kurang: $qtyDibutuhkan");
                    }
                }
                // Update Status Layanan
                model_ts_layanan_header::where('id', $d->idheader)
                    ->update(['status_bayar' => 1, 'status_layanan' => 2]);
                model_ts_kunjungan::where('id', $idkunjungan)
                    ->update(['status_kunjungan' => 2]);
                model_ts_antrian::where('id_kunjungan', $idkunjungan)
                    ->update(['status' => 4]);
            }
            DB::commit();
            return response()->json([
                'kode' => 200,
                'status' => 'success',
                'pesan' => 'Pembayaran berhasil disimpan!',
                'view' => view('Kasirfarmasi.reportpembayaran', compact('kembalian'))->render()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'kode' => 500,
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    public function simpanpembayaran2(Request $request)
    {
        $idkunjungan = $request->idkunjungan;
        $totalbruto = $request->totaltagihanasli;
        $bayar = $request->uangbayarasli;
        $diskon = $request->diskon;
        if ($diskon != 0) {
            $diskontunai = $totalbruto * $diskon / 100;
            $total = $totalbruto - $diskontunai;
        } else {
            $diskontunai = 0;
            $total = $totalbruto;
        }
        if ($bayar < $total) {
            return response()->json([
                'kode' => 500,
                'status' => 'error',
                'message'  => 'Uang bayar tidak cukup !'
            ]);
            die;
        }
        $kembalian = $bayar - $total;
        $datenow = Carbon::now()->format('Y-m-d');
        $dataheader2 = [
            'id_transaksi' => $this->generateNoTransaksi(),
            'id_kunjungan' => $idkunjungan,
            'tgl_transaksi' => $datenow,
            'total_bruto' => $totalbruto,
            'total_diskon' =>  $diskontunai,
            'total_neto' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'pic' => auth()->user()->id,
            'tgl_entry' => $datenow,
        ];
        $dataheader = DB::select('
            SELECT 
                a.id as idheader,
                b.id as iddetail,
                b.subtotal,
                b.kode_barang, -- Ambil kode barang
                b.id_tarif,     -- Ambil id tarif
                b.jumlah           -- Ambil jumlah yang digunakan
            FROM ts_layanan_header a 
            INNER JOIN ts_layanan_detail b ON a.id = b.id_header 
            WHERE a.id_kunjungan = ? 
            AND a.status_layanan = ? 
            AND b.status_layanan = ?', [$idkunjungan, 1, 1]);
        $kunjungan = db::select('select * from ts_kunjungan b inner join master_pasien a on b.nomor_rm = a.nomor_rm where b.id = ?', [$idkunjungan]);
        $header = model_ts_transaksi_kasir_header::create($dataheader2);
        DB::transaction(function () use ($dataheader, $header, $kunjungan) {
            foreach ($dataheader as $d) {
                model_ts_transaksi_kasir_detail::create([
                    'id_header'         => $header->id,
                    'id_layanan_header' => $d->idheader,
                    'id_layanan_detail' => $d->iddetail,
                    'kode_barang'       => $d->kode_barang,
                    'id_tarif'          => $d->id_tarif,
                    'subtotal'          => $d->subtotal
                ]);
                if (!empty($d->kode_barang)) {
                    $qtyDibutuhkan = $d->jumlah;
                    $batches = DB::table('ts_stok_batch')
                        ->where('kode_barang', $d->kode_barang)
                        ->where('stok_now', '>', 0)
                        ->orderBy('tgl_ed', 'asc')
                        ->get();
                    foreach ($batches as $batch) {
                        if ($qtyDibutuhkan <= 0) break;

                        $jumlahDipotong = min($qtyDibutuhkan, $batch->stok_now);
                        $stokBaru = $batch->stok_now - $jumlahDipotong;
                        DB::table('ts_stok_batch')
                            ->where('id', $batch->id)
                            ->update(['stok_now' => $stokBaru]);
                        $stokTerakhir_kartu = DB::table('ts_kartu_stok')
                            ->where('kode_barang', $d->kode_barang)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->first();
                        if (!$stokTerakhir_kartu) {
                            $stok_last = 0;
                        } else {
                            $stok_last = $stokTerakhir_kartu->stok_sekarang;
                        }
                        $stok_sekarang = $stok_last - $d->jumlah;
                        DB::table('ts_kartu_stok')->insert([
                            'tgl_transaksi'    => now(),
                            'kode_barang'  => $d->kode_barang,
                            'no_batch'     => $batch->no_batch,
                            'kode_unit'     => 5,
                            'stok_masuk'    => 0,
                            'stok_keluar'       => $d->jumlah,
                            'stok_terakhir'    => $stok_last,
                            'stok_sekarang'   => $stok_sekarang,
                            'keterangan'   => $kunjungan[0]->nomor_rm . ' | ' . $kunjungan[0]->nama_pasien,
                            'no_referensi'   => 'Transaksi Kasir No: ' . $header->no_transaksi,
                            'harga_jual'   => '',
                            'margin' => '',
                            'pic' => auth()->user()->id
                        ]);
                        $qtyDibutuhkan -= $jumlahDipotong;
                    }
                    if ($qtyDibutuhkan > 0) {
                        throw new \Exception("Stok barang {$d->kode_barang} tidak mencukupi!");
                    }
                }
                model_ts_layanan_header::where('id', $d->idheader)
                    ->update(['status_bayar' => 1, 'status_layanan' => 2]);
            }
        });
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'pesan'  => 'Pembayaran berhasil disimpan !',
            'view'   => view('Kasirfarmasi.reportpembayaran', compact([
                'kembalian'
            ]))->render() // Jika butuh kirim HTML
        ]);
    }
    public function ambildatatagihan(Request $request)
    {
        $id_kunjungan = $request->idkunjungan;
        $data = DB::table('ts_layanan_header as a')
            ->select(
                'a.id as idheader',
                'a.kode_layanan_header',
                'a.tgl_layanan',
                'b.nama_tarif',
                'b.id as iddetail',
                'b.jumlah',
                'b.harga_satuan',
                'b.subtotal',
            )
            ->join('ts_layanan_detail as b', 'a.id', '=', 'b.id_header')
            ->where('a.id_kunjungan', $id_kunjungan)
            ->where('b.status_layanan', 1)
            ->where('a.status_layanan', 1)
            ->get();
        return view('Kasirfarmasi.tabeltagihan', compact([
            'data'
        ]));
    }
    public function terimaresep(Request $request)
    {
        $idkunjungan = $request->id;
        $paketresep = $request->paketresep;
        $data_resep = db::select('select * from ts_resep_header a inner join ts_resep_detail b on a.id = b.id_header where a.id_kunjungan = ? and status_resep = 1 and b.status_obat = 1', [$idkunjungan]);
        if (count($data_resep) == 0) {
            $data2 = [
                'kode' => 500,
                'message' => 'Tidak ada resep yang diterima ...'
            ];
            echo json_encode($data2);
            die;
        }
        $datenow = Carbon::now()->format('Y-m-d');
        $KODE = $this->generateKodeLayanan();
        $data_header = [
            'id_kunjungan' => $idkunjungan,
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
        foreach ($data_resep as $t) {
            $mt_barang = db::select('select nama_barang,harga_jual,isi_konversi FROM master_barang where kode_barang = ?', [$t->kode_barang]);
            if ($paketresep == 1) {
                $harga = 0;
            } else {
                $harga = $mt_barang[0]->harga_jual / $mt_barang[0]->isi_konversi;
            }
            $data_detail = [
                'id_header' => $h->id,
                'kode_barang' => $t->kode_barang,
                'nama_tarif' => $mt_barang[0]->nama_barang,
                'harga_satuan' => $harga,
                'jumlah' => $t->qty,
                'subtotal' => $harga * $t->qty,
                'status_layanan' => 1,
            ];
            $subtotal = $harga * $t->qty;
            model_ts_layanan_detail::create($data_detail);
            $total_tagihan = $total_tagihan + $subtotal;
        }
        model_ts_layanan_header::where('id', $h->id)->update(['total_tagihan' => $total_tagihan, 'status_layanan' => 1]);
        model_ts_resep_header::where('id_kunjungan', $idkunjungan)
            ->where('status_resep', 1) // Ini otomatis dianggap sebagai "AND"
            ->update(['status_resep' => 2]);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function returorderobat(Request $request)
    {
        $id = $request->iddetail;
        model_ts_resep_detail::where('id', $id)->update(['status_obat' => 3]);
        $data2 = [
            'kode' => 200,
            'message' => 'Order berhasil dibatalkan ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function returlayanan(Request $request)
    {
        $id = $request->iddetail;
        $detail = db::select('select * from ts_layanan_detail where id = ?', [$id]);
        $dataup = [
            'jumlah' => 0,
            'subtotal' => 0,
            'status_layanan' => 3
        ];
        $subtot = $detail[0]->subtotal;
        $idheader = $detail[0]->id_header;
        model_ts_layanan_detail::where('id', $id)->update($dataup);
        $header = db::select('select * from ts_layanan_header where id = ?', [$idheader]);
        $total_tagihan = $header[0]->total_tagihan - $subtot;
        $cek_detail = db::select('select * from ts_layanan_detail where id_header = ? and status_layanan = 1', [$idheader]);
        if (count($cek_detail) > 0) {
            $status_layanan = 1;
        } else {
            $status_layanan = 3;
        }
        $dataup2 = [
            'total_tagihan' => $total_tagihan,
            'status_layanan' => $status_layanan
        ];
        model_ts_layanan_header::where('id', $idheader)->update($dataup2);
        $data2 = [
            'kode' => 200,
            'message' => 'Order berhasil dibatalkan ...'
        ];
        echo json_encode($data2);
        die;
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
    public function generateNoTransaksi()
    {
        $prefix = "TRX-" . date('Ymd'); // Hasil: TRX-20260228

        // Cari transaksi terakhir pada hari ini
        $lastTransaction = DB::table('ts_transaksi_kasir_header')
            ->where('id_transaksi', 'LIKE', $prefix . '%')
            ->orderBy('id_transaksi', 'desc')
            ->first();

        if (!$lastTransaction) {
            // Jika belum ada transaksi hari ini, mulai dari 0001
            $newNoUrut = "0001";
        } else {
            // Ambil 4 angka terakhir, tambah 1
            $lastNoUrut = substr($lastTransaction->id_transaksi, -4);
            $newNoUrut = str_pad((int)$lastNoUrut + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . '-' . $newNoUrut;
    }
    public function getKartuStok(Request $request)
    {
        // Query untuk mengambil ID terakhir per kode_barang
        $latestIds = DB::table('ts_kartu_stok')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('kode_barang');

        // Query utama untuk mengambil detail berdasarkan ID terakhir tersebut
        $data = DB::table('ts_kartu_stok as t')
            ->joinSub($latestIds, 'latest', function ($join) {
                $join->on('t.id', '=', 'latest.id');
            })
            ->leftJoin('master_barang as b', 't.kode_barang', '=', 'b.kode_barang')
            ->select(
                't.kode_barang',
                'b.nama_barang',
                't.no_batch',
                't.keterangan',
                't.stok_terakhir', // Stok sebelum transaksi terakhir
                't.stok_masuk',
                't.stok_keluar',
                't.stok_sekarang', // Saldo Akhir Saat Ini
                't.tgl_transaksi'
            )
            ->orderBy('t.id','DESC')
            ->get();
        return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('tgl_transaksi', function ($row) {
                return date('d-m-Y H:i', strtotime($row->tgl_transaksi));
            })
            ->make(true);
    }
}
