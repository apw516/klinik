<?php

namespace App\Http\Controllers;

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
        return view('Poliklinik.form_erm_poliklinik', compact([
            'mt_pasien',
            'data_kunjungan',
            'dk',
            'tarif',
            'idkunjungan',
            'stokSemua'
        ]));
    }
    public function simpancatatanmedis(Request $request)
    {
        $no_resep = $this->generateNoResep();
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
            if ($index3 == 'aturanpakai') {
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
            $dataheader = [
                'no_resep' => $no_resep,
                'id_kunjungan' => $dataSet['idkunjungan'],
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
}
