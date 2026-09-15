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
        $data = db::select('select a.*,b.nomor_antrian,d.nama_pasien,c.nama_unit,e.nama_lengkap as nama_dokter ,a.status_kunjungan from ts_kunjungan a 
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
            ->select('k.*', 'p.nama_lengkap as nama_dokter', 'u.nama_unit', 'k.jenis_kunjungan')
            ->where('k.nomor_rm', $nomor_rm)
            ->orderBy('k.id', 'desc')
            ->get();
        $tarif = db::select('select * from mt_tarif_np_medika');
        $mt_barang = db::select('select * from mt_barang_np_medika');
        // $dataobat = db::select('select * ,b.keterangan as keterangan_obat from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.id_kunjungan = ? and a.keterangan = ? and b.status_layanan != 3', [$idkunjungan, 'OBAT']);

        // $last_order = db::select('select * ,b.keterangan as keterangan_obat from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.id_kunjungan = ? and a.keterangan = ? and b.status_layanan != 3', [$idkunjungan, 'OBAT']);

        // 1. Cari ID kunjungan obat terakhir untuk RM tersebut
        $maxKunjunganId = DB::table('ts_kunjungan as k')
            ->join('ts_layanan_header as h', 'k.id', '=', 'h.id_kunjungan')
            ->where('k.nomor_rm', $nomor_rm)
            ->where('h.keterangan', 'OBAT')
            ->max('k.id'); // atau ->max('h.id_kunjungan')

        // 2. Ambil detail order obatnya
        $dataobat = DB::table('ts_layanan_header as a')
            ->select('a.*', 'b.keterangan as keterangan_obat', 'c.nomor_rm', 'b.nama_tarif', 'b.kode_barang', 'b.jumlah', 'b.signa', 'b.status_paket', 'd.golongan_obat')
            ->join('ts_layanan_detail as b', 'a.id', '=', 'b.id_header')
            ->join('ts_kunjungan as c', 'c.id', '=', 'a.id_kunjungan')
            ->join('mt_barang_np_medika as d', 'b.kode_barang', '=', 'd.id')
            ->where('a.id_kunjungan', $maxKunjunganId)
            ->where('a.keterangan', 'OBAT')
            ->where('b.status_layanan', '!=', 3)
            ->get();
        // dd($dataobat);
        return view('Poliklinik.form_erm_poliklinik', compact([
            'mt_pasien',
            'data_kunjungan',
            'dk',
            'tarif',
            'idkunjungan',
            'mt_barang',
            'dataobat'
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
        $arrayobat = [];
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'status_paket') {
                $arrayobat[] = $dataSet3;
            }
        }
        if (count($arrayobat) > 0) {
            if (count($arrayobat) <= 3) {
                $kondisi = 1;
            } elseif (count($arrayobat) == 4) {
                $kondisi = 2;
            } elseif (count($arrayobat) > 4) {
                $kondisi = 3;
            }
        }
        $planning = '';
        foreach ($arrayobat as $index => $b) {
            $idkunjungan = $dataSet['idkunjungan'];
            if ($b['kode_kunjungan'] != $idkunjungan) {
                $namabarang =  $b['namabarang'];
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
                $qty = $b['qty'];
                $planning = $planning . ' / ' . $namabarang . ' Jumlah :' . $qty . ' Aturan Pakai : ' . $aturan_pakai;
            }
        }
        $dataup = [
            'SUBJECT' => $dataSet['subject'],
            'OBJECT' => $dataSet['object'],
            'ASSESMENT' => $dataSet['assesmen'],
            'PLANNING' => $dataSet['planning'] . $planning,
            'namadiagnosa' => $dataSet['namadiagnosa'],
            'kodediagnosa' => $dataSet['kodediagnosa'],
            'status_periksa' => 2
        ];
        $data_kunjungan = db::select('select * from ts_kunjungan where id = ?', [$dataSet['idkunjungan']]);
        $mt_pasien = db::select('select * from master_pasien where nomor_rm = ? ', [$data_kunjungan[0]->nomor_rm]);
        $namapasien = $mt_pasien[0]->nama_pasien;
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
        $jlhobatorder = 0;
        foreach ($arrayobat as $index => $b) {
            if ($b['kode_kunjungan'] == 0) {
                $jlhobatorder = $jlhobatorder + 1;
            }
        }
        if (count($data3) > 0) {
            $datenow = Carbon::now()->format('Y-m-d');
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
            if ($jlhobatorder > 0) {
                $h = model_ts_layanan_header::create($data_header);
                $total_tagihan = 0;
                $obatke = 0;
                foreach ($arrayobat as $index => $b) {
                    if ($b['kode_kunjungan'] != $idkunjungan) {
                        $obatke = $obatke + 1;
                        $paket = data_get($b, 'is_paket', 0) ? 1 : 0;
                        // 2. Ambil data master barang
                        $mt_barang = DB::select('select id, nama_barang, harga_normal,harga_tebus FROM mt_barang_np_medika where id = ?', [$b['kodebarang']]);
                        if ($data_kunjungan[0]->jenis_kunjungan == 3) {
                        }
                        if (empty($mt_barang)) {
                            continue; // Lewati jika kode barang tidak ditemukan di master
                        }
                        $barangMaster = $mt_barang[0];
                        if ($paket == 1) {
                            $harga = 0;
                            $status_paket = 'YA';
                        } else {
                            $harga = $barangMaster->harga_normal;
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
                        $aturanPakaiString = !empty($checkboxObatIni) ? implode(', ', $checkboxObatIni) : '-';
                        $keteranganObat = $b['keterangan_obat'];
                        if ($data_kunjungan[0]->jenis_kunjungan == 3) {
                            if ($kondisi == 1) {
                                $harga = $barangMaster->harga_tebus;
                            } elseif ($kondisi == 2) {
                                $harga = $barangMaster->harga_tebus;
                            } elseif ($kondisi == 3) {
                                $harga = $barangMaster->harga_tebus;
                                if ($obatke > 4) {
                                    $harga = $barangMaster->harga_normal;
                                }
                            }
                        }
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
                    }
                }
                // dd($obatke);
                // Update nilai akumulasi di header layanan pasien
                model_ts_layanan_header::where('id', $h->id)->update(['total_tagihan' => $total_tagihan, 'status_layanan' => 1]);
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
    public function ambilhasillab(Request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $hasillab = model_hasil_lab::where('kode_kunjungan', $kode_kunjungan)->first();
        $datalayanan = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where id_kunjungan = ? and b.status_layanan = 1 and a.status_layanan != 3', [$kode_kunjungan]);
        return view('Poliklinik.hasillab', compact([
            'hasillab',
            'datalayanan'
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
    public function searchDiagnosa(Request $request)
    {
        $search = $request->get('term');

        // Validasi backend: batasi pencarian hanya jika panjang karakter > 3
        if (!$search || strlen(trim($search)) <= 3) {
            return response()->json([]);
        }

        $result = DB::table('mt_icd10')
            ->where('nama', 'LIKE', '%' . $search . '%')
            ->orWhere('diag', 'LIKE', '%' . $search . '%')
            ->limit(15)
            ->get();

        $response = [];
        foreach ($result as $item) {
            $response[] = [
                'label' => $item->diag . ' - ' . $item->nama,
                'value' => $item->nama,
                'kode'  => $item->diag,
            ];
        }

        return response()->json($response);
    }
}
