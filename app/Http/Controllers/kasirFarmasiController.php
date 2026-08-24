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
    public function indexorderobatpasien()
    {
        $menu_sub = 'indexorderobat';
        $menu = 'indexorderobat';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Farmasi.indexdatapasien', compact([
            'menu',
            'menu_sub',
            'datenow',
        ]));
    }
    public function indexdatapasienkasirfarmasi()
    {
        $menu_sub = 'indexdatapasienkasirfarmasi';
        $menu = 'indexdatapasienkasirfarmasi';
        $datenow = Carbon::now()->format('Y-m-d');
        $cek_sesi = db::select('select * from ts_log_sesi_kasir where id_user = ? and status = ? and date(tgl_mulai) = ?', [auth()->user()->id, 1, $datenow]);
        return view('Kasirfarmasi.indexdatapasien', compact([
            'menu',
            'menu_sub',
            'datenow',
            'cek_sesi'
        ]));
    }
    public function simpansesikasir(Request $request)
    {
        $saldoawal = $request->saldoawal;
        $datenow = Carbon::now()->format('Y-m-d H:i:s');

        $data = [
            'id_user' => auth()->user()->id,
            'nama_user' => auth()->user()->nama,
            'tgl_mulai' => $datenow,
            'saldo_awal' => $saldoawal,
            'status' => 1,
        ];
        try {
            // Proses Insert ke Database
            DB::table('ts_log_sesi_kasir')->insert($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Sesi kasir berhasil dibuka.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuka sesi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function tutupsesikasir(Request $request)
    {
        $idsesi = $request->idsesi;
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $total = db::select('select sum(total_neto) jumlahsaldo from ts_transaksi_kasir_header where id_sesi = ? and status = 1', [$idsesi]);
        $sesi = db::select('select * from ts_log_sesi_kasir where id = ?', [$idsesi]);
        $data = [
            'tgl_selesai' => $datenow,
            'status' => 2,
            'saldo_akhir' => $total[0]->jumlahsaldo
        ];
        try {
            // Proses Insert ke Database
            DB::table('ts_log_sesi_kasir')->where('id', $idsesi)->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Sesi kasir berhasil ditutup.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menutup sesi: ' . $e->getMessage()
            ], 500);
        }
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
    public function indexlogsesikasir()
    {
        $menu_sub = 'indexlogsesikasir';
        $menu = 'indexlogsesikasir';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Kasirfarmasi.indexlogsesikasir', compact([
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
    public function ambildataorderobatpasien(Request $request)
    {
        $tanggalawal = $request->tanggalawal;
        $tanggalakhir = $request->tanggalakhir;
        $data = DB::table('ts_layanan_header as a')
            ->select(
                'a.id_kunjungan',
                'a.id as id_header',
                'b.tgl_masuk',
                'b.nomor_rm',
                'b.unit_tujuan',
                'b.jenis_kunjungan',
                'b.dokter',
                'c.nama_pasien',
                'd.nama_lengkap as nama_dokter',
                'e.nama_unit',
                'a.status_order',

                // Aggregate / Penghitungan
                DB::raw("COUNT(CASE WHEN a.status_layanan = 1 THEN a.id END) as jumlah_belum_bayar"),
                DB::raw("COUNT(CASE WHEN a.status_layanan = 2 THEN a.id END) as jumlah_sudah_bayar"),
                DB::raw("COUNT(a.id) as total_layanan_header"), // Sudah otomatis tidak menghitung status 3 karena ada di WHERE
                DB::raw("MAX(a.tgl_layanan) as tgl_layanan_terakhir")
            )
            ->join('ts_kunjungan as b', 'a.id_kunjungan', '=', 'b.id')
            ->join('master_pasien as c', 'b.nomor_rm', '=', 'c.nomor_rm')
            ->leftJoin('master_pegawai as d', 'b.dokter', '=', 'd.id')
            ->leftJoin('master_unit as e', 'b.unit_tujuan', '=', 'e.id')
            ->whereBetween('a.tgl_layanan', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->where('a.status_layanan', '!=', 3)
            ->where('a.keterangan', '=', 'OBAT')
            ->groupBy(
                'a.id_kunjungan',
                'a.id', // <-- PERBAIKAN: Harus a.id (sesuai id_header di select)
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
        return view('Kasirfarmasi.tabel_data_pasien_order', compact([
            'data'
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
    public function ambilsesikasir(Request $request)
    {
        $tanggalAwal = $request->tanggalawal . ' 00:00:00';
        $tanggalAkhir = $request->tanggalakhir . ' 23:59:59';
        $data = DB::table('ts_log_sesi_kasir as a')
            ->select(
                'a.id as idtx',
                'a.nama_user',
                'a.tgl_mulai',
                'a.tgl_selesai',
                'a.saldo_awal',
                'a.saldo_akhir',
                'a.status'
            )
            ->whereBetween('a.tgl_mulai', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('a.id', 'desc')
            ->get();
        return view('Kasirfarmasi.tabel_log_sesi_kasir', compact([
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
                'd.id as idlayananheader',
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
    public function ambilformpemberianobat(Request $request)
    {
        $idlayananheader = $request->idlayanan;
        $idkunjungan = $request->idkunjungan;
        $mt_barang = db::select('select * from mt_barang where stok_global > 0');
        return view('Farmasi.form_pemberian_obat', compact([
            'idlayananheader',
            'idkunjungan',
            'mt_barang'
        ]));
    }
    public function ambildataorderobat(Request $request)
    {
        $idlayananheader = $request->idlayananheader;
        $data = db::select('select a.id as id_header,b.id as id_detail,c.kode_barang,c.nama_barang,b.aturan_pakai,b.jumlah,c.stok_global,b.signa,a.status_order from ts_layanan_header a 
        inner join ts_layanan_detail b on a.id = b.id_header 
        inner join mt_barang c on b.kode_barang = c.kode_barang
        where b.id_header = ? and a.keterangan = ? and b.status_layanan = ?', [$idlayananheader, 'OBAT', 1]);
        return view('Farmasi.list_obat', compact([
            'data',
            'idlayananheader'
        ]));
    }
    public function berikanobatpasien(Request $request)
    {
        $idlayananheader = $request->idlayananheader;
        db::table('ts_layanan_detail')->where('id_header', $idlayananheader)->update(['keterangan_resep' => 'SUDAH DIBERIKAN KEPADA PASIEN']);
        db::table('ts_layanan_header')->where('id', $idlayananheader)->update(['status_order' => 'SUDAH DIBERIKAN KEPADA PASIEN']);
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'pesan' => 'Resep berhasil dilayani',
        ]);
    }
    public function ambilformpembayarankasir(Request $request)
    {
        $idlayananheader = $request->idlayanan;
        $idkunjungan = $request->idkunjungan;
        $tarif = db::select('select * from master_tarif_pelayanan');
        $mt_barang = db::select('select * from mt_barang where stok_global > 0');
        return view('Kasirfarmasi.form_pembayaran', compact([
            'idlayananheader',
            'idkunjungan',
            'tarif',
            'mt_barang'
        ]));
    }
    public function returpembayaran(Request $request)
    {
        // $idheader = $request->idheader;
        // model_ts_transaksi_kasir_header::where('id', $idheader)->update(['status' => 2]);
        // $detail = db::select('select * from ts_transaksi_kasir_detail where id_header = ?', [$idheader]);
        // foreach ($detail as $dd) {
        //     $id_detail = $dd->id;
        //     $idlydt = $dd->id_layanan_detail;
        //     $idlyhd = $dd->id_layanan_header;
        //     $dataheader = [
        //         'status_bayar' => 0,
        //         'status_layanan' => 1
        //     ];
        //     model_ts_layanan_header::where('id', $idlyhd)->update($dataheader);
        // }
        DB::transaction(function () use ($request) {
            $idheader = $request->idheader;

            // 1. Ambil data header transaksi kasir terlebih dahulu
            $kasirHeader = model_ts_transaksi_kasir_header::where('id', $idheader)->first();

            if ($kasirHeader) {
                $idSesiKasir = $kasirHeader->id_sesi;
                // Sesuaikan nama kolom total bayar/grand total yang ada di tabel transaksi kasir header Anda
                $totalRetur  = $kasirHeader->total_neto;
                // 2. Update status transaksi kasir header menjadi retur (status 2)
                $kasirHeader->update(['status' => 2]);

                // 3. Update tabel log_sesi_kasir: Kurangi saldo_akhir & buka kembali status sesi (status = 1)
                if ($idSesiKasir) {
                    DB::table('ts_log_sesi_kasir')
                        ->where('id', $idSesiKasir)
                        ->update([
                            'saldo_akhir' => DB::raw("saldo_akhir - {$totalRetur}"),
                            'status'      => 1 // 1 = Terbuka Kembali (Sesuaikan dengan flag status terbuka di sistem Anda)
                        ]);
                }

                // 4. Update status layanan header terkait dari detail transaksi
                $detail = DB::select('select * from ts_transaksi_kasir_detail where id_header = ?', [$idheader]);

                foreach ($detail as $dd) {
                    $idlyhd = $dd->id_layanan_header;

                    $dataheader = [
                        'status_bayar'   => 0,
                        'status_layanan' => 1
                    ];

                    model_ts_layanan_header::where('id', $idlyhd)->update($dataheader);
                }
            }
        });
        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran berhasil dibatalkan ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function detailtagihan(Request $request)
    {
        $id = $request->idheader;
        $header = db::select('select * from ts_layanan_header where id = ?', [$id]);
        $data = db::select('select * from  ts_layanan_detail where id_header = ? and status_layanan != 3', [$id]);
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'message' => 'Berhasil!',
            'view' => view('Kasirfarmasi.detailtagihan', compact('data', 'header'))->render()
        ]);
    }
    public function detailpembayaran(Request $request)
    {
        $id = $request->idheader;
        $idtrans = $request->idtrans;
        $header = db::select('select * from ts_transaksi_kasir_header where id = ?', [$id]);
        $data = db::select('select * from ts_transaksi_kasir_detail a left join ts_layanan_detail b on a.id_layanan_detail = b.id where a.id_header = ?', [$id]);
        return response()->json([
            'kode' => 200,
            'status' => 'success',
            'message' => 'Berhasil!',
            'view' => view('Kasirfarmasi.detail_pembayaran', compact('data', 'idtrans', 'header'))->render()
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
        $datenow = Carbon::now()->format('Y-m-d');
        $cek_sesi = db::select('select * from ts_log_sesi_kasir where id_user = ? and status = ? and date(tgl_mulai) = ?', [auth()->user()->id, 1, $datenow]);
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
            'id_sesi'       => $cek_sesi[0]->id
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

                // Update Status Layanan
                model_ts_layanan_header::where('id', $d->idheader)
                    ->update(['status_bayar' => 1, 'status_layanan' => 2]);
                model_ts_kunjungan::where('id', $idkunjungan)
                    ->update(['status_kunjungan' => 2]);
                model_ts_antrian::where('id_kunjungan', $idkunjungan)
                    ->update(['status' => 4]);
            }
            DB::commit();
            $id_header = $header->id;
            return response()->json([
                'kode' => 200,
                'status' => 'success',
                'pesan' => 'Pembayaran berhasil disimpan!',
                'view' => view('Kasirfarmasi.reportpembayaran', compact('kembalian', 'id_header'))->render()
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
            ->where('a.status_bayar', 0)
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

        // 1. Ambil data detail layanan yang akan diretur
        $detail = DB::select('select * from ts_layanan_detail where id = ?', [$id]);
        if (empty($detail)) {
            return response()->json(['kode' => 404, 'message' => 'Detail layanan tidak ditemukan.']);
        }

        $detailRow   = $detail[0];
        $subtot      = $detailRow->subtotal;
        $idheader    = $detailRow->id_header;
        $kodeBarang  = $detailRow->kode_barang;
        $qtyRetur    = (int) $detailRow->jumlah; // Jumlah qty obat yang dibatalkan

        // 2. Jalankan DB Transaction
        DB::beginTransaction();

        try {
            // =========================================================================
            // PROSES PENGEMBALIAN STOK OBAT (JIKA KODE_BARANG BUKAN '0' ATAU BUKAN JASA)
            // =========================================================================
            if ($kodeBarang != '0' && $qtyRetur > 0) {

                // Ambil data log transaksi keluar yang merekam pemotongan obat untuk layanan ini sebelumnya
                // Kita spesifikkan berdasarkan kode_barang, jenis_transaksi KELUAR, dan ID Header/Detail pada keterangan
                $logsKeluar = DB::table('mt_log_persediaan_barang')
                    ->where('kode_barang', $kodeBarang)
                    ->where('jenis_transaksi', 'KELUAR')
                    ->where('keterangan', 'like', '%Detail Layanan ID: ' . $idheader . '%')
                    ->get();

                // Ambil stok global saat ini di master barang sebelum dikembalikan
                $masterBarang = DB::table('mt_barang')->where('kode_barang', $kodeBarang)->first();
                $stokAwalGlobal = $masterBarang ? (int) $masterBarang->stok_global : 0;

                if ($logsKeluar->isNotEmpty()) {
                    foreach ($logsKeluar as $log) {
                        $jumlahKembali = (int) $log->jumlah;

                        // A. Kembalikan stok_sekarang ke batch asalnya di mt_stok_persediaan_barang
                        DB::table('mt_stok_persediaan_barang')
                            ->where('id', $log->id_persediaan)
                            ->increment('stok_sekarang', $jumlahKembali);

                        // B. Kembalikan stok_global di tabel master barang (mt_barang)
                        DB::table('mt_barang')
                            ->where('kode_barang', $kodeBarang)
                            ->increment('stok_global', $jumlahKembali);

                        $stokAkhirGlobal = $stokAwalGlobal + $jumlahKembali;

                        // C. Catat Log Baru berupa mutasi MASUK (Pembatalan/Retur Obat Pasien)
                        DB::table('mt_log_persediaan_barang')->insert([
                            'kode_barang'     => $kodeBarang,
                            'no_batch'        => $log->no_batch,
                            'id_persediaan'   => $log->id_persediaan,
                            'jenis_transaksi' => 'MASUK',
                            'keterangan'      => 'Pembatalan/Retur Obat Pasien (Detail Layanan ID: ' . $idheader . ')',
                            'jumlah'          => $jumlahKembali,
                            'stok_awal'       => $stokAwalGlobal,
                            'stok_akhir'      => $stokAkhirGlobal,
                            'user_id'         => auth()->id() ?? null,
                            'tanggal_log'     => now()->toDateString(),
                            'created_at'      => now(),
                            'updated_at'      => now(),
                        ]);

                        // Gulung nilai stok awal global untuk loop log berikutnya jika multi-batch
                        $stokAwalGlobal = $stokAkhirGlobal;
                    }
                } else {
                    // BACKUP PLAN: Jika log lama tidak ditemukan (data migrasi/manual), kembalikan ke batch ED terdekat yang aktif
                    $batchTerdekat = DB::table('mt_stok_persediaan_barang')
                        ->where('kode_barang', $kodeBarang)
                        ->orderBy('tanggal_kadaluwarsa', 'asc')
                        ->first();

                    if ($batchTerdekat) {
                        DB::table('mt_stok_persediaan_barang')->where('id', $batchTerdekat->id)->increment('stok_sekarang', $qtyRetur);
                        DB::table('mt_barang')->where('kode_barang', $kodeBarang)->increment('stok_global', $qtyRetur);

                        DB::table('mt_log_persediaan_barang')->insert([
                            'kode_barang'     => $kodeBarang,
                            'no_batch'        => $batchTerdekat->no_batch,
                            'id_persediaan'   => $batchTerdekat->id,
                            'jenis_transaksi' => 'MASUK',
                            'keterangan'      => 'Pembatalan Obat Pasien (Tanpa Log Lama - ED Terdekat) ID Header: ' . $idheader,
                            'jumlah'          => $qtyRetur,
                            'stok_awal'       => $stokAwalGlobal,
                            'stok_akhir'      => $stokAwalGlobal + $qtyRetur,
                            'user_id'         => auth()->id() ?? null,
                            'tanggal_log'     => now()->toDateString(),
                            'created_at'      => now(),
                            'updated_at'      => now(),
                        ]);
                    }
                }
            }

            // =========================================================================
            // PROSES UPDATE DATA LAYANAN (DETAIL & HEADER)
            // =========================================================================

            // 3. Reset jumlah & subtotal detail layanan menjadi 0, status_layanan = 3 (Batal/Retur)
            $dataup = [
                'jumlah' => 0,
                'subtotal' => 0,
                'status_layanan' => 3
            ];
            model_ts_layanan_detail::where('id', $id)->update($dataup);

            // 4. Hitung ulang total_tagihan pada header layanan
            $header = DB::select('select * from ts_layanan_header where id = ?', [$idheader]);
            $total_tagihan = $header[0]->total_tagihan - $subtot;

            // 5. Cek apakah masih ada tindakan/obat lain yang aktif (status_layanan = 1) di nota ini
            $cek_detail = DB::select('select * from ts_layanan_detail where id_header = ? and status_layanan = 1', [$idheader]);
            $status_layanan = (count($cek_detail) > 0) ? 1 : 3;

            // 6. Update data header layanan
            $dataup2 = [
                'total_tagihan' => $total_tagihan,
                'status_layanan' => $status_layanan
            ];
            model_ts_layanan_header::where('id', $idheader)->update($dataup2);

            // Commit semua transaksi jika berhasil tanpa hambatan
            DB::commit();


            $data2 = [
                'kode' => 200,
                'message' => 'Order berhasil dibatalkan ...'
            ];
            echo json_encode($data2);
            // die;
        } catch (\Exception $e) {
            // Rollback database jika terjadi error SQL
            DB::rollBack();

            $data2 = [
                'kode' => 500,
                'message' => 'Gagal meretur layanan. Terjadi kesalahan: ' . $e->getMessage()
            ];
            echo json_encode($data2);
            die;
        }
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
        $latestIds = DB::table('mt_log_persediaan_barang as t')
            ->select(DB::raw('MAX(id) as id'))
            ->leftJoin('mt_barang as b', 't.kode_barang', '=', 'b.kode_barang')
            ->select('*')
            ->orderBy('t.id', 'DESC')
            ->get();
        return DataTables()->of($latestIds)
            ->addIndexColumn()
            ->editColumn('tanggal_log', function ($row) {
                return date('d-m-Y H:i', strtotime($row->tanggal_log));
            })
            ->make(true);
    }
    public function savenewbill(Request $request)
    {
        $data3 = json_decode($_POST['data3'], true);
        foreach ($data3 as $nama2) {
            $index2 = $nama2['name'];
            $value2 = $nama2['value'];
            $dataSet2[$index2] = $value2;
            if ($index2 == 'harga') {
                $arraytarif[] = $dataSet2;
            }
        }
        if (count($data3) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
            $KODE = $this->generateKodeLayanan();
            $data_header = [
                'id_kunjungan' => $request->idkunjungan,
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
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function saveobt(Request $request)
    {
        $data3 = json_decode($_POST['data3'], true);
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'status_paket') {
                $arrayobat[] = $dataSet3;
            }
        }
        if (count($data3) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
            $datenow = Carbon::now()->format('Y-m-d');
            $KODE = $this->generateKodeLayanan();
            $idkunjungan = $request->idkunjungan;
            $data_kunjungan = db::select('select * from ts_kunjungan where id = ?', [$idkunjungan]);
            $mt_pasien = db::select('select * from master_pasien where nomor_rm = ? ', [$data_kunjungan[0]->nomor_rm]);
            $namapasien = $mt_pasien[0]->nama_pasien;
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
            foreach ($arrayobat as $index => $b) {
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
                if (empty($b['sebelum_makan'])) {
                    $aturan_1 = '';
                } else {
                    $aturan_1 = 'Sebelum Makan';
                }
                if (empty($b['sesudah_makan'])) {
                    $aturan_2 = '';
                } else {
                    $aturan_2 = 'Sesudah Makan';
                }
                if (empty($b['pagi'])) {
                    $aturan_3 = '';
                } else {
                    $aturan_3 = ', Pagi';
                }
                if (empty($b['siang'])) {
                    $aturan_4 = '';
                } else {
                    $aturan_4 = ', Siang';
                }
                if (empty($b['sore'])) {
                    $aturan_5 = '';
                } else {
                    $aturan_5 = ', Sore';
                }
                if (empty($b['malam'])) {
                    $aturan_6 = '';
                } else {
                    $aturan_6 = ', Malam';
                }
                $aturan_pakai = $aturan_1 . $aturan_2 . $aturan_3  . $aturan_4 . $aturan_5  . $aturan_6;
                $subtotal = $harga * $b['qty'];

                // =========================================================================
                // PENYESUAIAN BARU: PROSES COUPLING ATURAN PAKAI CHECKBOX & KETERANGAN
                // =========================================================================

                // A. Ambil array aturan pakai khusus untuk kode_barang ini dari request global
                // Struktur request: $request->aturan_pakai[kode_barang] = ['Sesudah Makan', 'Pagi', 'Malam']
                // $checkboxObatIni = request()->input("aturan_pakai." . $b['kodebarang'], []);
                // dd($checkboxObatIni);
                // Gabungkan array menjadi satu teks string dipisahkan tanda koma
                $aturanPakaiString = !empty($checkboxObatIni) ? implode(', ', $checkboxObatIni) : '-';

                // B. Ambil keterangan berdasarkan index baris obat saat ini
                $keteranganObat = $b['keterangan_obat'];
                // 3. Insert ke detail layanan pasien
                $data_detail = [
                    'id_header'       => $h->id,
                    'kode_barang'     => $b['kodebarang'],
                    'nama_tarif'      => $barangMaster->nama_barang,
                    'harga_satuan'    => $harga,
                    'jumlah'          => $b['qty'],
                    'subtotal'        => $subtotal,
                    'status_layanan'  => 1,
                    'aturan_pakai'    => $aturan_pakai, // Menyimpan teks gabungan checkbox ("Sesudah Makan, Pagi")
                    'signa'      => $keteranganObat,    // Menyimpan teks input catatan keterangan obat
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
                        'keterangan'      => 'Pengurangan Obat Pasien ' . $namapasien . '(Detail Layanan ID: ' . $h->id . ')',
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
                    // throw new \Exception("Stok obat untuk kode " . $b['kodebarang'] . " kurang.");
                }
            }

            // Update nilai akumulasi di header layanan pasien
            model_ts_layanan_header::where('id', $h->id)->update(['total_tagihan' => $total_tagihan, 'status_layanan' => 1]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function cetaknotakasir($id)
    {
        // 1. Query Header menggunakan Query Builder
        $header = DB::table('ts_transaksi_kasir_header')
            ->where('id', $id)
            ->first();

        if (!$header) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        // 2. Query Detail (Agregasi Total Tagihan)
        // Semua tarif item digabungkan/dijumlahkan menjadi satu
        $totalPaket = DB::table('ts_transaksi_kasir_detail as a')
            ->join('ts_layanan_detail as b', 'a.id_layanan_detail', '=', 'b.id')
            ->where('a.id_header', $id)
            ->sum('a.subtotal'); // Sesuaikan 'total_tarif' dengan nama kolom harga di tabel Anda

        return view('Kasirfarmasi.cetak_nota', compact('header', 'totalPaket'));
    }
    public function checkPaymentCount()
    {
        $count = DB::table('ts_layanan_header')
            ->where('status_bayar', 1)
            ->whereDate('tgl_layanan', now()->today()) // atau date('Y-m-d')
            ->count();

        return response()->json([
            'total' => $count
        ]);
    }
}
