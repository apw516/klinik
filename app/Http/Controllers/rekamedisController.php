<?php

namespace App\Http\Controllers;

use App\Models\model_ts_antrian;
use App\Models\model_ts_kunjungan;
use App\Models\model_ts_layanan_detail;
use App\Models\model_ts_layanan_header;
use App\Models\model_ts_resep_detail;
use App\Models\model_ts_resep_header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class rekamedisController extends Controller
{
    public function indexdaftarpelayanan()
    {
        $menu_sub = 'indexdaftarpelayanan';
        $menu = 'indexdaftarpelayanan';
        return view('Rekamedis.index_daftar_pelayanan', compact([
            'menu',
            'menu_sub'
        ]));
    }
    public function indexriwayatpendaftaran()
    {
        $menu_sub = 'indexriwayatpendaftaran';
        $menu = 'indexriwayatpendaftaran';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Rekamedis.indexriwayatpendaftaran', compact([
            'menu',
            'menu_sub',
            'datenow',
        ]));
    }
    public function caridatapasien(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $datapasien[$index] = $value;
        }
        $rm = $datapasien['nomorrm'];
        $nomoridentitas = $datapasien['nomoridentitas'];
        $nomorasuransi = $datapasien['nomorasuransi'];
        $namapasien = $datapasien['namapasien'];
        $namadesa = $datapasien['namadesa'];
        $data = db::select('CALL WSP_PANGGIL_DATAPASIEN(?,?,?,?)', [$rm, $namapasien, $namadesa, $nomoridentitas]);
        return view('Rekamedis.tabel_data_pasien', compact([
            'data'
        ]));
    }
    public function ambilformpendaftaran(Request $request)
    {
        $rm = $request->rm;
        $mt_pasien = db::select('select * from master_pasien where nomor_rm = ?', [$rm]);
        $mt_unit = db::select('select * from master_unit where id_klinik = ?', [auth()->user()->id_klinik]);
        $dokter = db::select('select * from master_pegawai where id_klinik = ? and posisi_kerja = ?', [auth()->user()->id_klinik, 'DOKTER']);
        // $data_kunjungan = db::select('select * from ts_kunjungan where nomor_rm = ? order by id desc', [$rm]);
        $data_kunjungan = DB::table('ts_kunjungan as k')
            ->leftJoin('master_pegawai as p', 'k.dokter', '=', 'p.id')
            ->leftJoin('master_unit as u', 'k.unit_tujuan', '=', 'u.id')
            ->select('k.*', 'p.nama_lengkap as nama_dokter', 'u.nama_unit')
            ->where('k.nomor_rm', $rm)
            ->orderBy('k.id', 'desc')
            ->get();
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Rekamedis.form_pendaftaran', compact([
            'mt_pasien',
            'mt_unit',
            'dokter',
            'data_kunjungan',
            'datenow',
            'rm'
        ]));
    }
    public function simpanpendaftaranpasien(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datenow = Carbon::now()->format('Y-m-d');
        $cek_kunjungan = db::select('select status_kunjungan from ts_kunjungan where nomor_rm = ? and status_kunjungan = ? order by id desc', [$dataSet['no_rm'], 1]);
        if ($dataSet['tujuankunjungan'] != 5) {
            if ($dataSet['dokter'] == 0) {
                $data2 = [
                    'kode' => 500,
                    'message' => 'Pendaftaran gagal, Dokter belum dipilih ...'
                ];
                echo json_encode($data2);
                die;
            }
        }
        if (count($cek_kunjungan) > 0) {
            $data2 = [
                'kode' => 500,
                'message' => 'Pendaftaran gagal, ada kunjungan yang belum selesai ...'
            ];
            echo json_encode($data2);
            die;
        }
        $cek_counter = db::select('select counter from ts_kunjungan where nomor_rm = ? order by id desc', [$dataSet['no_rm']]);
        if (count($cek_counter) > 0) {
            $counter = $cek_counter[0]->counter + 1;
        } else {
            $counter = 1;
        }
        $data_save = [
            'tgl_entry' => $datenow,
            'tgl_masuk' => $dataSet['tanggalkunjungan'],
            'nomor_rm' => $dataSet['no_rm'],
            'unit_tujuan' => $dataSet['tujuankunjungan'],
            'jenis_kunjungan' => $dataSet['jeniskunjungan'],
            'dokter' => $dataSet['dokter'],
            'counter' => $counter,
            'tekanan_darah' => $dataSet['tekanandarah'],
            'suhu_tubuh' => $dataSet['suhutubuh'],
            'keluhan_utama' => $dataSet['keluhanutama'],
            'pic' => auth()->user()->id,
            'id_klinik' => 1,
        ];
        $k = model_ts_kunjungan::create($data_save);
        $no_antrian = $this->get_antrian($dataSet['tujuankunjungan'], $dataSet['tanggalkunjungan']);
        $data_antrian = [
            'nomor_urut' => $no_antrian['no_urut'],
            'nomor_antrian' => $no_antrian['no_antrian'],
            'unit' => $dataSet['tujuankunjungan'],
            'tgl_antri' => $dataSet['tanggalkunjungan'],
            'status' => 1,
            'id_kunjungan' => $k->id,
            'nomor_rm' => $dataSet['no_rm']
        ];
        model_ts_antrian::create($data_antrian);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function formeditkunjungan(Request $request)
    {
        $id = $request->idkunjungan;
        $data = model_ts_kunjungan::where('id', $id)->get();
        return view('Rekamedis.formeditkunjungan', compact([
            'data',
            'id'
        ]));
    }
    public function ambildetailkunjungan(Request $request)
    {
        $id = $request->idkunjungan;
        // $data = model_ts_kunjungan::where('id', $id)->get();

        $data = model_ts_kunjungan::where('ts_kunjungan.id', $id)
            ->leftJoin('master_pegawai', 'ts_kunjungan.dokter', '=', 'master_pegawai.id')
            ->leftJoin('master_unit', 'ts_kunjungan.unit_tujuan', '=', 'master_unit.id')
            ->select(
                'ts_kunjungan.*',
                'master_pegawai.nama_lengkap as nama_dokter',
                'master_unit.nama_unit'
            )
            ->first();
        return view('Rekamedis.detailkunjungan', compact([
            'data',
            'id'
        ]));
    }
    public function ambildetailkunjungan_billing(Request $request)
    {
        $id = $request->idkunjungan;
        $data = model_ts_kunjungan::where('ts_kunjungan.id', $id)
            ->leftJoin('master_pegawai', 'ts_kunjungan.dokter', '=', 'master_pegawai.id')
            ->leftJoin('master_unit', 'ts_kunjungan.unit_tujuan', '=', 'master_unit.id')
            ->select(
                'ts_kunjungan.*',
                'master_pegawai.nama_lengkap as nama_dokter',
                'master_unit.nama_unit'
            )
            ->first();
        $ly = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.id_kunjungan = ? and a.status_layanan != 3', [$id]);
        return view('Rekamedis.detailkunjungan_2', compact([
            'data',
            'id',
            'ly'
        ]));
    }
    public function ambilforminputlayanan(Request $request)
    {
        $idkunjungan = $request->idkunjungan;
        $kunjungan = db::select('select * from ts_kunjungan where id = ?', [$idkunjungan]);
        $pasien = db::select('select * from master_pasien where nomor_rm = ?', [$kunjungan[0]->nomor_rm]);
        $tarif = db::select('select * from master_tarif_pelayanan');
        $stokSemua = DB::table('ts_kartu_stok as t1')
            ->select(
                't1.kode_barang',
                't1.stok_sekarang',
                'mb.nama_barang',
                'mb.margin', // sesuaikan nama kolom margin di tabel master
                'batch.tgl_ed',
                'batch.harga_beli_terakhir',
                'mb.aturan_pakai'
            )
            ->join('master_barang as mb', 't1.kode_barang', '=', 'mb.kode_barang')
            // Join dengan subquery untuk mendapatkan ED terdekat dan Harga Beli terbaru dari tabel batch
            ->leftJoin(DB::raw('(
            SELECT 
                kode_barang, 
                MIN(tgl_ed) as tgl_ed, 
                MAX(harga_beli) as harga_beli_terakhir
            FROM ts_stok_batch
            WHERE stok_now > 0
            GROUP BY kode_barang
            ) as batch'), 't1.kode_barang', '=', 'batch.kode_barang')
            ->whereIn('t1.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('ts_kartu_stok')
                    ->groupBy('kode_barang');
            })
            ->get();
        return view('Rekamedis.form_input_layanan', compact([
            'kunjungan',
            'pasien',
            'tarif',
            'stokSemua',
            'idkunjungan'
        ]));
    }
    public function simpaneditstatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $data = model_ts_kunjungan::where('id', $id)->update(['status_kunjungan' => $status]);
        if ($status == 3) {
            $status_antri = 5;
            $data33 = model_ts_antrian::where('id_kunjungan', $id)->update(['status' => $status_antri]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanbatalkunjungan(Request $request)
    {
        $id = $request->idkunjungan;
        $status = 3;
        $data = model_ts_kunjungan::where('id', $id)->update(['status_kunjungan' => $status]);
        if ($status == 3) {
            $status_antri = 5;
            $data33 = model_ts_antrian::where('id_kunjungan', $id)->update(['status' => $status_antri]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function indexdataantrian()
    {
        $menu_sub = 'indexdataantrian';
        $menu = 'indexdataantrian';
        $datenow = Carbon::now()->format('Y-m-d');
        return view('Rekamedis.index_data_antrian', compact([
            'menu',
            'menu_sub',
            'datenow'
        ]));
    }
    public function ambildataantrian(Request $request)
    {
        $tanggal = $request->tgl;
        $data = model_ts_antrian::whereRaw('DATE(tgl_antri) = ?', [$tanggal])
            ->join('master_unit', 'ts_antrian_pasien.unit', '=', 'master_unit.id')
            ->join('master_pasien', 'ts_antrian_pasien.nomor_rm', '=', 'master_pasien.nomor_rm')
            ->select('ts_antrian_pasien.*', 'master_unit.nama_unit', 'master_pasien.nama_pasien') // Ambil semua kolom antrian + nama unit
            ->orderBy('ts_antrian_pasien.nomor_urut', 'asc')
            ->get();
        return view('Rekamedis.tabel_antrian_pasien', compact([
            'data'
        ]));
    }
    public function ambilriwayatpendaftaran(Request $request)
    {
        $tanggalAwal = $request->tanggalawal . ' 00:00:00';
        $tanggalAkhir = $request->tanggalakhir . ' 23:59:59';
        $data = DB::table('ts_kunjungan as a')
            ->select(
                'a.id as id_kunjungan',
                'a.id as id_kunjungan',
                'a.tgl_masuk',
                'e.nomor_antrian',
                'a.nomor_rm',
                'b.nama_pasien',
                'b.tempat_lahir',
                'c.nama_unit',
                'd.nama_lengkap as nama_dokter',
                'a.status_kunjungan'
            )
            ->join('master_pasien as b', 'a.nomor_rm', '=', 'b.nomor_rm')
            ->join('master_unit as c', 'a.unit_tujuan', '=', 'c.id')
            ->leftJoin('master_pegawai as d', 'a.dokter', '=', 'd.id') // Gunakan leftJoin jika kolom dokter bisa kosong
            ->leftJoin('ts_antrian_pasien as e', 'a.id', '=', 'e.id_kunjungan') // Gunakan leftJoin jika kolom dokter bisa kosong
            ->whereBetween('a.tgl_masuk', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('a.tgl_masuk', 'desc')
            ->get();
        return view('Rekamedis.tabel_riwayat_pendaftaran', compact([
            'data'
        ]));
    }
    public function get_antrian($unit, $tanggal)
    {
        $unit = $unit; // Contoh: 'POL01'
        $tgl_hari_ini = $tanggal;
        $mt_unit = db::select('select * from master_unit where id = ?', [$unit]);
        $last_urut = DB::table('ts_antrian_pasien')
            ->where('unit', $unit)
            ->whereDate('tgl_antri', $tgl_hari_ini)
            ->max('nomor_urut'); // Mengambil angka tertinggi

        $no_urut_baru = $last_urut ? $last_urut + 1 : 1;
        $prefix = $mt_unit[0]->prefix;
        $no_antrian = $prefix . '-' . str_pad($no_urut_baru, 3, '0', STR_PAD_LEFT);
        $dataantrian = [
            'no_antrian' => $no_antrian,
            'no_urut' => $no_urut_baru
        ];
        return $dataantrian;
    }
    public function ambilformupdateantrian(Request $request)
    {
        $id = $request->idantrian;
        $data = model_ts_antrian::where('id', $id)->get();
        return view('Rekamedis.formeditantrian', compact([
            'data',
            'id'
        ]));
    }
    public function simpaneditstatusantrian(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $data = model_ts_antrian::where('id', $id)->update(['status' => $status]);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanbilling(Request $request)
    {
        $no_resep = $this->generateNoResep();
        $data2 = json_decode($_POST['data2'], true);
        $data3 = json_decode($_POST['data3'], true);
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
            if ($index3 == 'aturanpakai') {
                $arrayobat[] = $dataSet3;
            }
        }
        if (count($data2) > 0) {
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
        if (count($data3) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
            $data_kunjungan = db::select('select * from ts_kunjungan where id = ?', [$request->idkunjungan]);
            $dataheader = [
                'no_resep' => $no_resep,
                'id_kunjungan' => $request->idkunjungan,
                'no_rm' => $data_kunjungan[0]->nomor_rm,
                'dokter' => $data_kunjungan[0]->dokter,
                'unit_kirim' => $data_kunjungan[0]->unit_tujuan,
                'tgl_resep' => $datenow,
                'status_resep' => '1'
            ];
            $rh = model_ts_resep_header::create($dataheader);
            foreach ($arrayobat as $b) {
                $data_detail = [
                    'id_header' => $rh->id,
                    'kode_barang' => $b['kodebarang'],
                    'qty' => $b['qty'],
                    'aturan_pakai' => $b['aturanpakai'],
                    'status_obat' => 1,
                ];
                model_ts_resep_detail::create($data_detail);
            }


            $idkunjungan = $request->idkunjungan;
            $paketresep = 0;
            $data_resep = db::select('select * from ts_resep_header a inner join ts_resep_detail b on a.id = b.id_header where a.id_kunjungan = ? and status_resep = 1 and b.status_obat = 1', [$idkunjungan]);
            // if (count($data_resep) == 0) {
            //     $data2 = [
            //         'kode' => 500,
            //         'message' => 'Tidak ada resep yang diterima ...'
            //     ];
            //     echo json_encode($data2);
            //     die;
            // }

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
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
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
}
