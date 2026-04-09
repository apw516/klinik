<?php

namespace App\Http\Controllers;

use App\Models\model_master_barang;
use App\Models\model_master_generik;
use App\Models\model_master_pasien;
use App\Models\model_master_supllier;
use App\Models\model_mt_unit;
use App\Models\model_ts_kartu_stok;
use App\Models\model_ts_stok_batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class dataMasterController extends Controller
{
    public function indexmasterpasien()
    {
        $menu_sub = 'indexmasterpasien';
        $menu = 'indexmasterpasien';
        // $data = db::select('SELECT a.*,b.`nama_jenis` AS nama_jenis_identitas,c.`jenis_asuransi`,c.`nama_asuransi`,d.`nama_status`,fc_nama_klinik(a.`id_klinik`) AS nama_klinik FROM master_pasien a 
        // LEFT OUTER JOIN master_jenis_identitas b ON a.jenis_identitas = b.id 
        // LEFT OUTER JOIN master_asuransi c ON a.`jenis_asuransi` = c.`id`
        // LEFT OUTER JOIN master_status_pernikahan d ON a.`status_pernikahan` = d.`id`
        // WHERE a.is_active = 1
        // ORDER BY id DESC');
        return view('Master.index_master_pasien', compact([
            'menu',
            // 'data',
            'menu_sub'
        ]));
    }
    public function indexdatamasterpasien(Request $request)
    {
        // dd('ok');
        // if ($request->ajax()) {
            $data = DB::table('master_pasien'); // Ganti dengan nama tabel Anda
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-warning" title="Edit"
                        onclick="editpasien(\'' . $row->id . '\')" data-bs-toggle="modal" data-bs-target="#editmasterpasien">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger" title="Hapus"
                        onclick="hapuspasien(\'' . $row->id . '\')">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>';
                })
                ->rawColumns(['aksi']) // Agar HTML tombol dirender
                ->make(true);
        // }
        // return view('Master.tabel_pasien', compact([
        //     'data'
        // ])); // Sesuaikan path view Anda
    }
    public function indexmasterbarang()
    {
        $menu_sub = 'indexmasterbarang';
        $menu = 'indexmasterbarang';
        $data = db::select('select a.*,b.nama_generik_lengkap as nama_generik,b.nama_zat_aktif,fc_nama_klinik(a.id_klinik) as nama_klinik,d.nama_supplier,c.nama as nama_jenis_barang from master_barang a left outer join master_obat_generik b on a.id_generik = b.id left outer join master_jenis_barang c on a.jenis_barang = c.id left outer join master_supplier d on a.id_supplier = d.id');
        $data_s = db::select('select * from master_sediaan_obat');
        return view('Master.index_master_barang', compact([
            'menu',
            'data',
            'menu_sub',
            'data_s'
        ]));
    }
    public function indexdataobatgenerik()
    {
        $menu_sub = 'indexdataobatgenerik';
        $menu = 'indexdataobatgenerik';
        $data = db::select('select a.*,b.nama_kategori,b.keterangan,c.nama_sediaan,d.nama_satuan_dosis from master_obat_generik a inner join master_kategori_obat b on a.kategori_obat = b.id inner join master_sediaan_obat c on a.sediaan = c.id inner join master_satuan_dosis d on a.satuan_dosis = d.id');
        $sediaan = db::select('select * from master_sediaan_obat');
        $dosis = db::select('select * from master_satuan_dosis');
        $kategori = db::select('select * from master_kategori_obat');
        return view('Master.index_master_obat_generik', compact([
            'menu',
            'data',
            'menu_sub',
            'sediaan',
            'dosis',
            'kategori'
        ]));
    }
    public function indexdataicd10()
    {
        $menu_sub = 'indexdataicd10';
        $menu = 'indexdataicd10';
        $data = db::select('select * from mt_icd10');
        return view('Master.index_data_icd_10', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdataicd9()
    {
        $menu_sub = 'indexdataicd9';
        $menu = 'indexdataicd9';
        $data = db::select('select * from mt_icd9');
        return view('Master.index_data_icd_9', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatatarifpelayanan()
    {
        $menu_sub = 'indexdatatarifpelayanan';
        $menu = 'indexdatatarifpelayanan';
        $data = db::select('select *,fc_nama_klinik(id_klinik) as nama_klinik from master_tarif_pelayanan');
        return view('Master.index_data_tarif_pelayanan', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatapegawai()
    {
        $menu_sub = 'indexdatapegawai';
        $menu = 'indexdatapegawai';
        $data = db::select('select *,fc_nama_klinik(id_klinik) as nama_klinik from master_pegawai');
        return view('Master.index_data_pegawai', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdataunit()
    {
        $menu_sub = 'indexdataunit';
        $menu = 'indexdataunit';
        $data = db::select('select *,fc_nama_klinik(id_klinik) as nama_klinik from master_unit');
        return view('Master.index_data_unit', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function ambilformeditpasien(Request $request)
    {
        $id = $request->id;
        $pasien = db::select('select * from master_pasien where id = ?', [$id]);
        // $provinsi = db::select('select * from mt_provinsi where code = ?', [$pasien[0]->provinsi]);
        // $kab = db::select('select * from mt_kabupaten_kota where bps_code = ?', [$pasien[0]->kabupaten]);
        // $kec = db::select('select * from mt_kecamatan where code = ?', [$pasien[0]->kecamatan]);
        // $desa = db::select('select * from mt_desa where bps_code = ?', [$pasien[0]->desa]);
        return view('Master.formeditpasien', compact([
            'pasien',
            // 'desa',
            // 'provinsi',
            // 'kab',
            // 'kec'
        ]));
    }
    public function indexdataprovinsi()
    {
        $menu_sub = 'masterlokasi';
        $menu = 'indexdataprovinsi';
        $data = db::select('select * from mt_provinsi');
        return view('Master.index_data_provinsi', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatakabupatenkota()
    {
        $menu_sub = 'masterlokasi';
        $menu = 'indexdatakabupatenkota';
        $data = db::select('select * from mt_kabupaten_kota');
        return view('Master.index_data_kabupaten', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatakecamatan()
    {
        $menu_sub = 'masterlokasi';
        $menu = 'indexdatakecamatan';
        $data = db::select('select * from mt_kecamatan');
        return view('Master.index_data_kecamatan', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatadesa()
    {
        $menu_sub = 'masterlokasi';
        $menu = 'indexdatadesa';
        $data = db::select('select * from mt_desa');
        return view('Master.index_data_desa', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function indexdatauser()
    {
        $menu_sub = 'masteruser';
        $menu = 'indexdatauser';
        $data = db::select('select a.*,b.nama as nama_hak,fc_nama_klinik(a.id_klinik) as nama_klinik from user a left outer join master_hak_akses b on a.hak_akses = b.id');
        return view('Master.index_data_user', compact([
            'menu',
            'data',
            'menu_sub'
        ]));
    }
    public function cariGenerik(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI

        $data = DB::table('master_obat_generik')
            ->where('nama_generik_lengkap', 'LIKE', '%' . $term . '%')
            ->get();

        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->id,
                'label' => $row->nama_generik_lengkap,
                'value' => $row->nama_generik_lengkap
            ];
        }

        return response()->json($results);
    }
    public function cariProvinsi(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI

        $data = DB::table('mt_provinsi')
            ->where('name', 'LIKE', '%' . $term . '%')
            ->get();

        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->bps_code,
                'label' => $row->name,
                'value' => $row->name
            ];
        }

        return response()->json($results);
    }
    public function cariKabupaten(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI
        $idprovinsi = $request->idprovinsi;
        $data = DB::table('mt_kabupaten_kota')
            ->where('parent_code', $idprovinsi)
            ->where('name', 'LIKE', '%' . $term . '%')
            ->get();
        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->bps_code,
                'label' => $row->name,
                'value' => $row->name
            ];
        }

        return response()->json($results);
    }
    public function cariKecamatan(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI
        $idkabupaten = $request->idkabupaten;
        $data = DB::table('mt_kecamatan')
            ->where('parent_code', $idkabupaten)
            ->where('name', 'LIKE', '%' . $term . '%')
            ->get();
        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->code,
                'label' => $row->name,
                'value' => $row->name
            ];
        }

        return response()->json($results);
    }
    public function cariDesa(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI
        $idkecamatan = $request->idkecamatan;
        $data = DB::table('mt_desa')
            ->where('parent_code', $idkecamatan)
            ->where('name', 'LIKE', '%' . $term . '%')
            ->get();
        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->bps_code,
                'label' => $row->name,
                'value' => $row->name
            ];
        }

        return response()->json($results);
    }
    public function cariSupplier(Request $request)
    {
        $term = $request->get('term'); // Parameter otomatis dari jQuery UI

        $data = DB::table('master_supplier')
            ->where('nama_supplier', 'LIKE', '%' . $term . '%')
            ->get();
        $results = [];
        foreach ($data as $row) {
            // Label: teks yang muncul di daftar, Value: teks yang masuk ke input setelah diklik
            $results[] = [
                'id' => $row->id,
                'label' => $row->nama_supplier,
                'value' => $row->nama_supplier
            ];
        }

        return response()->json($results);
    }
    public function simpaneditpasien(Request $request)
    {
        $datenow = Carbon::now()->format('Y-m-d');
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_save = [
            'nomor_identitas' => $dataSet['editnomoridentitas'],
            'id_satu_sehat' => 0,
            'jenis_identitas' => $dataSet['editjenisidentitas'],
            'nama_pasien' => $dataSet['editnamapasien'],
            'jenis_kelamin' => $dataSet['editjeniskelamin'],
            'tempat_lahir' => $dataSet['edittempatlahir'],
            'alamat_ktp' => $dataSet['editalamatlengkap'],
            'alamat_domisili' => $dataSet['editalamatlengkap'],
            // 'provinsi' => $dataSet['editidprovinsi'],
            // 'kabupaten' => $dataSet['editidkabupaten'],
            // 'kecamatan' => $dataSet['editidkecamatan'],
            // 'desa' => $dataSet['editiddesa'],
            'nomor_asuransi' => $dataSet['editnomorasuransi'],
            'jenis_asuransi' => 0,
            'status_pernikahan' => $dataSet['editstatus_pernikahan'],
            'status_dol' => 1,
            'tgl_entry' => $datenow,
            'pic' => auth()->user()->id,
            'id_klinik' => 1,
            'tanggal_lahir' => $dataSet['edittanggallahir'],
        ];
        model_master_pasien::where('id', $dataSet['idpasien'])->update($data_save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanpasien(Request $request)
    {
        $datenow = Carbon::now()->format('Y-m-d');
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $rm = $this->generateNoRM();
        $data_save = [
            'nomor_rm' => $rm,
            'nomor_identitas' => $dataSet['nomoridentitas'],
            'id_satu_sehat' => 0,
            'jenis_identitas' => $dataSet['jenisidentitas'],
            'nama_pasien' => $dataSet['namapasien'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'alamat_ktp' => $dataSet['alamatlengkap'],
            'alamat_domisili' => $dataSet['alamatlengkap'],
            // 'provinsi' => $dataSet['idprovinsi'],
            // 'kabupaten' => $dataSet['idkabupaten'],
            // 'kecamatan' => $dataSet['idkecamatan'],
            // 'desa' => $dataSet['iddesa'],
            'nomor_asuransi' => $dataSet['nomorasuransi'],
            'jenis_asuransi' => 0,
            'status_pernikahan' => $dataSet['status_pernikahan'],
            'status_dol' => 1,
            'tgl_entry' => $datenow,
            'pic' => auth()->user()->id,
            'id_klinik' => 1,
            'tanggal_lahir' => $dataSet['tanggallahir'],
        ];
        model_master_pasien::create($data_save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpansupplier(Request $request)
    {
        $datenow = Carbon::now()->format('Y-m-d');
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_save = [
            'nama_supplier' => $dataSet['namasupplier2'],
            'no_telp' => $dataSet['notelp'],
            'alamat_supplier' => $dataSet['alamat'],
            'tgl_entry' => $datenow,
            'jenis_supplier' => 1
        ];
        model_master_supllier::create($data_save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanmasterbarang(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datenow = Carbon::now()->format('Y-m-d');
        $data_save = [
            'kode_barang' => $this->generateKodeBarang(),
            'nama_barang' => $dataSet['namabarang'],
            'jenis_barang' => 1,
            'id_generik' => $dataSet['id_generik'],
            'id_supplier' => $dataSet['id_supplier'],
            'id_klinik' => '1',
            'tgl_entry' => $datenow,
            'aturan_pakai' => $dataSet['aturanpakai'],
            'satuan_besar' => $dataSet['satuanbesar'],
            'satuan_kecil' => $dataSet['satuankecil'],
            'isi_konversi' => $dataSet['konversi'],
            'keterangan' => '',
            'pic' => auth()->user()->id,
        ];
        model_master_barang::create($data_save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilinfosediaan(Request $request)
    {
        $idbarang = $request->idbarang;
        $data = db::select('select *,a.harga_beli as hg from ts_stok_batch a inner join master_barang b on a.kode_barang = b.kode_barang where a.kode_barang = ?', [$idbarang]);
        return view('Master.tabel_sediaan', compact([
            'data'
        ]));
    }
    public function simpanmastergenerik(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datenow = Carbon::now()->format('Y-m-d');
        $data_save = [
            'kode_obat' => $this->generateKodeBarangGenerik(),
            'nama_zat_aktif' => $dataSet['namagenerik'],
            'sediaan' => $dataSet['sediaan'],
            'dosis' => $dataSet['dosis'],
            'satuan_dosis' => $dataSet['satuandosis'],
            'nama_generik_lengkap' => $dataSet['namageneriklengkap'],
            'kategori_obat' => $dataSet['kategoriobat'],
            'is_ogb' => 0,
        ];
        model_master_generik::create($data_save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanstokbaranginjek(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datenow = Carbon::now()->format('Y-m-d');
        $barang = db::select('select * from master_barang where kode_barang = ?', [$dataSet['kodebarang']]);
        $konversi = $barang[0]->isi_konversi;
        $stok_masuk = $dataSet['stokmasuk'] * $konversi;
        $data_save = [
            'kode_barang' => $dataSet['kodebarang'],
            'no_batch' => $dataSet['kodebatch'],
            'tgl_ed' => $dataSet['ed'],
            'harga_beli' => $dataSet['harga_asli'],
            'stok_awal' => $stok_masuk,
            'stok_now' => $stok_masuk,
            'tgl_stok' => $datenow,
            'pic' => auth()->user()->id,
        ];
        $sb = model_ts_stok_batch::create($data_save);
        $stokTerakhir = DB::table('ts_kartu_stok')
            ->where('kode_barang', $dataSet['kodebarang'])
            ->orderBy('id', 'desc')
            ->get()
            ->first();
        if (!$stokTerakhir) {
            $stok_last = 0;
        } else {
            $stok_last = $stokTerakhir->stok_sekarang;
        }
        $stok_sekarang = $stok_masuk + $stok_last;
        $data_stok = [
            'tgl_transaksi' => $datenow,
            'kode_barang' => $dataSet['kodebarang'],
            'kode_unit' => 5,
            'stok_masuk' => $stok_masuk,
            'stok_keluar' => 0,
            'stok_sekarang' => $stok_sekarang,
            'stok_terakhir' => $stok_last,
            'no_referensi' => $sb->id,
            'keterangan' => 'STOK INJECT',
            'no_batch' => $dataSet['kodebatch'],
        ];
        model_ts_kartu_stok::create($data_stok);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanunit(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datasave = [
            'tipe_unit' => $dataSet['tipeunit'],
            'nama_unit' => strtoupper($dataSet['namaunit']),
            'kelas' => $dataSet['kelas'],
            'status' => $dataSet['status'],
            'prefix' => 'A',
            'id_klinik' => 1,
        ];
        model_mt_unit::create($datasave);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpaneditunit(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datasave = [
            'tipe_unit' => $dataSet['tipeunitedit'],
            'nama_unit' => strtoupper($dataSet['namaunitedit']),
            'kelas' => $dataSet['kelasunitedit'],
            'status' => $dataSet['statusedit'],
        ];
        model_mt_unit::where('id', $dataSet['idunit'])
            ->update($datasave);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpaneditharga(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $margin = $dataSet['hargabeliasliedit'] * $dataSet['marginpenjualanedit'] / 100;
        $harga_jual = $dataSet['hargabeliasliedit'] + $margin;
        $datasave = [
            'harga_beli' => $dataSet['hargabeliasliedit'],
            'harga_jual' => $harga_jual,
            'margin' => strtoupper($dataSet['marginpenjualanedit']),
        ];
        model_master_barang::where('id', $dataSet['idbarangedit'])
            ->update($datasave);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function hapusunit(Request $request)
    {
        $idunit = $request->idunit;
        DB::table('master_unit')->where('id', $idunit)->delete();
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil dihapus ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanstatuspasien(Request $request)
    {
        $id = $request->idpasien;
        DB::table('master_pasien')->where('id', $id)->update(['is_active' => 2]);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function generateKodeBarang()
    {
        $prefix = "B";
        // 1. Ambil kode terakhir yang diawali dengan 'B'
        $lastRecord = DB::table('master_barang')
            ->where('kode_barang', 'LIKE', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        if ($lastRecord) {
            // 2. Ambil angka setelah huruf 'B' (karakter ke-2 sampai habis)
            $lastNumber = substr($lastRecord->kode_barang, 1);
            $nextNumber = (int)$lastNumber + 1;
        } else {
            // 3. Jika belum ada data sama sekali, mulai dari 1
            $nextNumber = 1;
        }

        // 4. Gabungkan prefix dengan angka yang dipadding 6 digit
        $newKode = $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return $newKode; // Hasil: B000001, B000002, dst.
    }
    public function generateKodeBarangGenerik()
    {
        $prefix = "G";
        // 1. Ambil kode terakhir yang diawali dengan 'B'
        $lastRecord = DB::table('master_obat_generik')
            ->where('kode_obat', 'LIKE', $prefix . '%')
            ->orderBy('kode_obat', 'desc')
            ->first();

        if ($lastRecord) {
            // 2. Ambil angka setelah huruf 'B' (karakter ke-2 sampai habis)
            $lastNumber = substr($lastRecord->kode_obat, 1);
            $nextNumber = (int)$lastNumber + 1;
        } else {
            // 3. Jika belum ada data sama sekali, mulai dari 1
            $nextNumber = 1;
        }

        // 4. Gabungkan prefix dengan angka yang dipadding 6 digit
        $newKode = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return $newKode; // Hasil: B000001, B000002, dst.
    }
    public function generateNoRM()
    {
        // 1. Ambil kode terakhir yang diawali dengan 'B'
        $lastRecord = DB::table('master_pasien')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord) {
            // 2. Ambil angka setelah huruf 'B' (karakter ke-2 sampai habis)
            $lastNumber = substr($lastRecord->nomor_rm, 1);
            $nextNumber = (int)$lastNumber + 1;
        } else {
            // 3. Jika belum ada data sama sekali, mulai dari 1
            $nextNumber = 1;
        }
        $datenow = Carbon::now()->format('ndy');
        // 4. Gabungkan prefix dengan angka yang dipadding 6 digit
        $newKode = $datenow . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        return $newKode; // Hasil: B000001, B000002, dst.
    }
    // public function generateNoRM($idDesa)
    // {
    //     // Pastikan kode desa selalu 2 digit (misal: 1 jadi 01)
    //     $prefix = str_pad($idDesa, 2, '0', STR_PAD_LEFT);
    //     // Ambil nomor urut terakhir dari desa tersebut
    //     $lastPatient = DB::table('master_pasien')
    //         ->where('desa', 'LIKE', $prefix . '%')
    //         ->lockForUpdate() // Mengunci baris agar tidak terjadi duplikasi saat traffic tinggi
    //         ->orderBy('nomor_rm', 'desc')
    //         ->first();

    //     if ($lastPatient) {
    //         // Ambil 5 digit terakhir dan tambah 1
    //         $lastNumber = (int) substr($lastPatient->nomor_rm, 2);
    //         $nextNumber = $lastNumber + 1;
    //     } else {
    //         // Jika pasien pertama di desa tersebut
    //         $nextNumber = 1;
    //     }
    //     $mt_desa = db::select('select id from mt_desa where bps_code = ?',[$prefix]);
    //     // Gabungkan kembali: KodeDesa + Urutan (5 digit)
    //     return $mt_desa[0]->id . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    // }
}
