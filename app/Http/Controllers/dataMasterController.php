<?php

namespace App\Http\Controllers;

use App\Models\model_master_barang;
use App\Models\model_master_generik;
use App\Models\model_master_pasien;
use App\Models\model_master_pegawai;
use App\Models\model_master_supllier;
use App\Models\model_mt_unit;
use App\Models\model_ts_kartu_stok;
use App\Models\model_ts_stok_batch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash; // <--- TAMBAHKAN BARIS INI

class dataMasterController extends Controller
{
    public function indexmasterpasien()
    {
        $menu_sub = 'indexmasterpasien';
        $menu = 'indexmasterpasien';
        $desa = db::select('select * from tabel_master_desa_baru ORDER By nama_desa ASC');
        return view('Master.index_master_pasien', compact([
            'menu',
            'desa',
            'menu_sub'
        ]));
    }
    public function indexstokpersediaan()
    {
        $menu_sub = 'indexstokpersediaan';
        $menu = 'indexstokpersediaan';
        $data = db::select('select * from mt_barang');
        return view('Master.indexstokpersediaan', compact([
            'menu',
            'menu_sub',
            'data'
        ]));
    }
    public function dataobat(Request $request)
    {
        // Sesuaikan 'mt_stok_persediaan_barang' dan 'master_barang' dengan nama tabel asli Anda
        $query = DB::table('mt_stok_persediaan_barang')
            ->join('mt_barang', 'mt_stok_persediaan_barang.kode_barang', '=', 'mt_barang.kode_barang')
            ->select([
                'mt_stok_persediaan_barang.tanggal_masuk', // atau created_at
                'mt_barang.kode_barang',
                'mt_barang.nama_barang',
                'mt_stok_persediaan_barang.harga_modal_ppn',
                'mt_barang.nama_generik',
                'mt_barang.nama_pabrik',
                'mt_stok_persediaan_barang.id',
                'mt_stok_persediaan_barang.id_supplier',
                'mt_stok_persediaan_barang.no_batch',
                'mt_stok_persediaan_barang.tanggal_kadaluwarsa', // ED
                'mt_stok_persediaan_barang.stok_awal',
                'mt_stok_persediaan_barang.stok_sekarang'
            ]);

        // 2. Hitung total data awal sebelum filter pencarian
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // 3. Logika Pencarian Global DataTables (Search Box)
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('mt_barang.kode_barang', 'LIKE', "%{$search}%")
                    ->orWhere('mt_barang.nama_barang', 'LIKE', "%{$search}%")
                    ->orWhere('mt_barang.nama_generik', 'LIKE', "%{$search}%")
                    ->orWhere('mt_stok_persediaan_barang.no_batch', 'LIKE', "%{$search}%");
            });

            // Hitung ulang total data setelah difilter pencarian
            $totalFiltered = $query->count();
        }

        // 4. Logika Pagination (Limit & Offset)
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        // Ambil data terurut berdasarkan tanggal masuk terbaru
        $results = $query->orderBy('mt_stok_persediaan_barang.id', 'DESC')
            ->offset($start)
            ->limit($limit)
            ->get();

        // 5. Format ulang struktur data agar cocok dengan urutan th di Blade
        $data = [];
        foreach ($results as $row) {
            $data[] = [
                // Format tanggal indonesia rapi
                'tanggal_masuk'      => date('d-m-Y', strtotime($row->tanggal_masuk)),
                'kode_barang'        => '<span class="fw-bold text-secondary text-uppercase">' . $row->kode_barang . '</span>',
                'id'        => $row->id,
                'nama_barang'        => $row->nama_barang,
                'id_supplier'        => $row->id_supplier,
                'nama_generik'       => $row->nama_generik ?? '-',
                'nama_pabrik'        => $row->nama_pabrik ?? '-',
                'no_batch'           => '<span class="badge bg-dark">' . $row->no_batch . '</span>',
                'no_batch2'           => $row->no_batch,
                'kode_barang2'           => $row->kode_barang,
                'harga_modal_ppn'           => $row->harga_modal_ppn,
                'stok_sekarang2'           => $row->stok_sekarang,
                // Format Expired Date
                'tanggal_kadaluwarsa' => date('d-m-Y', strtotime($row->tanggal_kadaluwarsa)),
                'stok_awal'          => number_format($row->stok_awal, 0, ',', '.'),
                'stok_sekarang'      => '<span class="fw-bold text-primary">' . number_format($row->stok_sekarang, 0, ',', '.') . '</span>'
            ];
        }

        // 6. Kembalikan response JSON standar DataTables
        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
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
                    <button type="button" class="btn btn-outline-danger" title="Non aktifkan"
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
        $data = db::select('select * from mt_barang');
        return view('Master.index_master_barang', compact([
            'menu',
            'data',
            'menu_sub',
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
        $desa = db::select('select * from tabel_master_desa_baru ORDER By nama_desa ASC');
        return view('Master.formeditpasien', compact([
            'pasien',
            'desa'
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
            'alamat_ktp' => $dataSet['alamatktp'],
            'alamat_domisili' => $dataSet['alamatlengkap'],
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
            'is_active' => $dataSet['is_active'],
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
        if ($dataSet['alamatktp'] == '-') {
            $data2 = [
                'kode' => 500,
                'message' => 'Desa belum dipilih !'
            ];
            echo json_encode($data2);
            die;
        }
        $rm = $this->generateNoRM($dataSet['alamatktp']);
        $data_save = [
            'nomor_rm' => $rm,
            'nomor_identitas' => $dataSet['nomoridentitas'],
            'id_satu_sehat' => 0,
            'jenis_identitas' => $dataSet['jenisidentitas'],
            'nama_pasien' => $dataSet['namapasien'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'alamat_ktp' => $dataSet['alamatktp'],
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
    public function simpandesa(Request $request)
    {
        $nama = strtoupper($request->nama);
        $maxPrefixDigit = DB::table('tabel_master_desa_baru')
            ->selectRaw("MAX(CAST(SUBSTRING(prefix, 3) AS UNSIGNED)) as max_digit")
            ->value('max_digit');

        // 2. Jika tabel masih kosong (null), mulai dari angka 1. Jika ada, tambahkan 1.
        $nextDigit = $maxPrefixDigit ? ($maxPrefixDigit + 1) : 1;

        // 3. Gabungkan kembali dengan teks 'NP' dan format agar menjadi 2 digit (misal: 01, 02, 10)
        $newPrefix = 'NP' . str_pad($nextDigit, 2, '0', STR_PAD_LEFT);

        // 4. Eksekusi Insert ke Database
        DB::table('tabel_master_desa_baru')->insert([
            'prefix'    => $newPrefix,
            'nama_desa' => $nama,
        ]);

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
    public function simpanpegawaiedit(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $save = [
            'NIP' => $dataSet['NIP'],
            'NIK' => $dataSet['NIK'],
            'nama_lengkap' => $dataSet['namalengkap'],
            'tanggal_lahir' => $dataSet['tanggallahir'],
            'tempat_lahir' => strtoupper($dataSet['tempatlahir']),
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'no_telp' => $dataSet['nomortelepon'],
            'alamat' => strtoupper($dataSet['alamat']),
            'posisi_kerja' => strtoupper($dataSet['jabatan']),
            'tanggal_masuk' => $dataSet['tanggalmasuk'],
            'status' => 1,
            'id_klinik' => 1,
            'status' => $dataSet['status'],
        ];
        model_master_pegawai::where('id', $dataSet['ID'])->update($save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanedituser(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        if ($dataSet['resetpassword'] == 2) {
            $password = '123456';
            $save = [
                'nama' => $dataSet['namalengkap'],
                'username' => $dataSet['username'],
                'hak_akses' => $dataSet['hak_akses'],
                'is_activated' => $dataSet['status'],
                'password' => Hash::make($password), // WAJIB di-bcrypt demi keamanan
            ];
        } else {
            $save = [
                'nama' => $dataSet['namalengkap'],
                'username' => $dataSet['username'],
                'hak_akses' => $dataSet['hak_akses'],
                'is_activated' => $dataSet['status'],
            ];
        }
        User::where('id', $dataSet['ID'])->update($save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function hapuspegawai(Request $request)
    {
        $id = $request->id;
        model_master_pegawai::where('id', $id)->delete();
        $response = [
            'code' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($response);
        die;
    }
    public function hapususer(Request $request)
    {
        $id = $request->iduser;
        User::where('id', $id)->delete();
        $response = [
            'code' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($response);
        die;
    }
    public function simpanpegawai(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $save = [
            'NIP' => $dataSet['NIP'],
            'NIK' => $dataSet['NIK'],
            'nama_lengkap' => $dataSet['namalengkap'],
            'tanggal_lahir' => $dataSet['tanggallahir'],
            'tempat_lahir' => strtoupper($dataSet['tempatlahir']),
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'no_telp' => $dataSet['nomortelepon'],
            'alamat' => strtoupper($dataSet['alamat']),
            'posisi_kerja' => strtoupper($dataSet['jabatan']),
            'tanggal_masuk' => $dataSet['tanggalmasuk'],
            'status' => 1,
            'id_klinik' => 1,
        ];
        model_master_pegawai::create($save);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambildatapegawai(Request $request)
    {
        $id = $request->idpegawai;
        $data = model_master_pegawai::where('id', $id)->first();
        $html = view('Master.formeditpegawai', compact(['data']))->render();
        $response = [
            'code' => 200,
            'html' => $html,
            'message' => 'sukses'
        ];
        echo json_encode($response);
        die;
    }
    public function ambildatauser(Request $request)
    {
        $id = $request->iduser;
        $data = User::where('id', $id)->first();
        $hak = db::select('select * from master_hak_akses');
        $html = view('Master.formedituser', compact(['data', 'hak']))->render();
        $response = [
            'code' => 200,
            'html' => $html,
            'message' => 'sukses'
        ];
        echo json_encode($response);
        die;
    }
    public function barangstore(Request $request)
    {
        try {
            DB::table('mt_barang')->insert([
                'kode_barang'   => $this->generateKodeBarang(), // Memastikan kode selalu Kapital
                'nama_barang'   => $request->nama_barang,
                'nama_generik'  => $request->nama_generik,
                'nama_pabrik'   => $request->nama_pabrik,
                'jenis_barang'  => $request->jenis_barang,
                'kategori_obat' => $request->kategori_obat,
                'satuan_besar'  => $request->satuan_besar,
                'satuan_sedang' => $request->satuan_sedang,
                'satuan_kecil'  => $request->satuan_kecil,
                'isi_konversi'  => $request->isi_konversi,
                'bentuk_sediaan'  => $request->bentuk_sediaan,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
            // Kembalikan response sukses (Ditangkap oleh success: function(response) di AJAX)
            return response()->json([
                'status'  => true,
                'message' => 'Data master barang baru berhasil disimpan!'
            ], 200);
        } catch (\Exception $e) {
            // Jika ada kendala koneksi database atau query error (Error 500)
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data ke server. Terjadi kesalahan sistem.'
            ], 500);
        }
    }
    public function barangedit(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        // dd($data);
        try {
            DB::table('mt_barang')
                ->where('id', $dataSet['id_barang']) // Tentukan ID data barang yang ingin diubah
                ->update([
                    'nama_barang'    => $dataSet['nama_barang'],
                    'nama_generik'   => $dataSet['nama_generik'],
                    'nama_pabrik'    => $dataSet['nama_pabrik'],
                    'jenis_barang'   => $dataSet['jenis_barang'],
                    'kategori_obat'  => $dataSet['kategori_obat'],
                    'satuan_besar'   => $dataSet['satuan_besar'],
                    'satuan_sedang'  => $dataSet['satuan_sedang'],
                    'satuan_kecil'   => $dataSet['satuan_kecil'],
                    'isi_konversi'   => $dataSet['isi_konversi'],
                    'bentuk_sediaan' => $dataSet['bentuk_sediaan'],
                    'harga_jual' => $dataSet['harga_jual'],
                    'updated_at'     => now(), // Cukup updated_at saja saat update
                ]);
            // Kembalikan response sukses (Ditangkap oleh success: function(response) di AJAX)
            return response()->json([
                'status'  => true,
                'message' => 'Data master barang  berhasil diedit!'
            ], 200);
        } catch (\Exception $e) {
            // Jika ada kendala koneksi database atau query error (Error 500)
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data ke server. Terjadi kesalahan sistem.'
            ], 500);
        }
    }
    public function hapusmasterbarang(Request $request)
    {
        $id = $request->idbarang;
        model_master_barang::where('id', $id)->delete();
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil dihapus ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilformeditbarang(Request $request)
    {
        $id = $request->idbarang;
        $data = model_master_barang::where('id', $id)->first();
        return view('Master.form_edit_barang', compact(['data']));
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
    public function simpanstokpersediaan(Request $request)
    {
        $rawData = json_decode($request->input('data'), true);
        if (empty($rawData)) {
            return response()->json([
                'kode' => 500,
                'message' => 'Tidak ada data barang yang dikirim atau format data salah.'
            ]);
        }

        // 2. Kelompokkan data berdasarkan indeks array input html []
        $barangIds = [];
        $noBatches = [];
        $tanggalKadaluwarsas = [];
        $stokAwals = [];
        $hargaModals = [];

        foreach ($rawData as $item) {
            if ($item['name'] === 'barang_id[]') {
                $barangIds[] = $item['value'];
            } elseif ($item['name'] === 'no_batch[]') {
                $noBatches[] = strtoupper($item['value']); // Force uppercase untuk batch
            } elseif ($item['name'] === 'tanggal_kadaluwarsa[]') {
                $tanggalKadaluwarsas[] = $item['value'];
            } elseif ($item['name'] === 'stok_awal[]') {
                $stokAwals[] = $item['value'];
            } elseif ($item['name'] === 'harga_modal[]') {
                $hargaModals[] = $item['value'];
            }
        }

        // 3. Gunakan DB::transaction untuk memastikan jika 1 baris gagal, semua dibatalkan (aman untuk stok)
        DB::beginTransaction();
        try {
            // Looping berdasarkan jumlah barang_id yang dikirim
            for ($i = 0; $i < count($barangIds); $i++) {
                // Validasi manual dasar di tingkat controller per baris
                if (empty($noBatches[$i]) || empty($tanggalKadaluwarsas[$i]) || empty($stokAwals[$i]) || empty($hargaModals[$i])) {
                    return response()->json([
                        'kode' => 500,
                        'message' => 'Ada kolom input batch, ED, harga modal, atau Stok Masuk yang masih kosong!'
                    ]);
                }

                // A. Ambil stok awal global sebelum ditambah (untuk kebutuhan log saldo awal)
                $masterBarang = DB::table('mt_barang')
                    ->where('kode_barang', $barangIds[$i])
                    ->first();

                $stokAwalGlobal = $masterBarang ? $masterBarang->stok_global : 0;
                $stokAkhirGlobal = $stokAwalGlobal + $stokAwals[$i];

                // B. Insert ke tabel riwayat batch / persediaan gudang
                $persediaan = DB::table('mt_stok_persediaan_barang')->insertGetId([
                    'kode_barang'         => $barangIds[$i],
                    'no_batch'            => $noBatches[$i],
                    'tanggal_kadaluwarsa' => $tanggalKadaluwarsas[$i],
                    'stok_awal'           => $stokAwals[$i],
                    'stok_sekarang'       => $stokAwals[$i],
                    'harga_modal_ppn'     => $hargaModals[$i],
                    'tanggal_masuk'       => now()->toDateString(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);

                // C. Update total akumulasi stok di tabel master barang
                DB::table('mt_barang')
                    ->where('kode_barang', $barangIds[$i])
                    ->increment('stok_global', $stokAwals[$i]);

                // D. Insert ke tabel log transaksi stok (Kartu Stok)
                // Sesuaikan 'log_stok_barang' dengan nama tabel log Anda
                DB::table('mt_log_persediaan_barang')->insert([
                    'kode_barang'    => $barangIds[$i],
                    'no_batch'       => $noBatches[$i],
                    'id_persediaan'       => $persediaan,
                    'jenis_transaksi' => 'MASUK', // Keterangan jenis mutasi
                    'keterangan'     => 'Input Stok Persediaan Baru / Penerimaan Barang',
                    'jumlah'         => $stokAwals[$i],
                    'stok_awal'      => $stokAwalGlobal,  // Saldo sebelum transaksi
                    'stok_akhir'     => $stokAkhirGlobal, // Saldo sesudah transaksi
                    'user_id'        => auth()->id() ?? null, // Mencatat siapa yang menginput (jika ada auth)
                    'tanggal_log'    => now()->toDateString(),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            // Jika semua baris berhasil di-insert tanpa error
            DB::commit();

            return response()->json([
                'kode' => 200,
                'message' => 'Semua data stok persediaan barang dan log transaksi berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            // Batalkan semua insert jika di tengah jalan ada query yang error
            DB::rollBack();

            return response()->json([
                'kode' => 500,
                'message' => 'Gagal menyimpan data persediaan. Terjadi kesalahan internal: ' . $e->getMessage()
            ]);
        }
    }
    public function returstokpersediaan(Request $request)
    {
        // 1. Validasi Input Request
        if (empty($request->id_persediaan) || empty($request->jumlah_retur) || empty($request->kode_barang)) {
            return response()->json([
                'kode' => 500,
                'message' => 'Data input tidak lengkap. Mohon periksa kembali form Anda.'
            ]);
        }

        $idPersediaan = $request->id_persediaan;
        $kodeBarang   = $request->kode_barang;
        $jumlahRetur  = (int) $request->jumlah_retur;
        $alasanRetur  = $request->alasan_retur ?? 'Retur Sediaan Barang';

        if ($jumlahRetur <= 0) {
            return response()->json([
                'kode' => 500,
                'message' => 'Jumlah retur harus lebih besar dari 0!'
            ]);
        }

        // 2. Jalankan DB Transaction demi keamanan data stok
        DB::beginTransaction();

        try {
            // A. Kunci & Ambil data dari tabel persediaan (Cek ketersediaan stok aktual)
            // Menggunakan lockForUpdate() mencegah 'race condition' jika diakses bersamaan
            $persediaan = DB::table('mt_stok_persediaan_barang')
                ->where('id', $idPersediaan)
                ->lockForUpdate()
                ->first();

            if (!$persediaan) {
                return response()->json([
                    'kode' => 500,
                    'message' => 'Data batch persediaan tidak ditemukan di sistem.'
                ]);
            }

            // Cek apakah stok sediaan tersebut mencukupi untuk diretur
            if ($persediaan->stok_sekarang < $jumlahRetur) {
                return response()->json([
                    'kode' => 500,
                    'message' => 'Gagal! Sisa stok pada batch ini tinggal ' . $persediaan->stok_sekarang . '. Tidak mencukupi untuk melakukan retur sebanyak ' . $jumlahRetur
                ]);
            }

            // B. Ambil data stok awal master barang sebelum dikurangi (untuk pencatatan saldo awal kartu log)
            $masterBarang = DB::table('mt_barang')
                ->where('kode_barang', $kodeBarang)
                ->first();

            $stokAwalGlobal  = $masterBarang ? $masterBarang->stok_global : 0;
            $stokAkhirGlobal = $stokAwalGlobal - $jumlahRetur;

            // --- EKSEKUSI 3 TABEL ---

            // [TABEL 1] Kurangi stok_sekarang pada tabel persediaan batch terkait
            DB::table('mt_stok_persediaan_barang')
                ->where('id', $idPersediaan)
                ->decrement('stok_sekarang', $jumlahRetur);

            // [TABEL 2] Kurangi stok_global pada tabel master barang
            DB::table('mt_barang')
                ->where('kode_barang', $kodeBarang)
                ->decrement('stok_global', $jumlahRetur);

            // [TABEL 3] Catat mutasi barang KELUAR ke tabel Log Persediaan Barang (Kartu Stok)
            DB::table('mt_log_persediaan_barang')->insert([
                'kode_barang'     => $kodeBarang,
                'no_batch'        => $persediaan->no_batch,
                'id_persediaan'   => $idPersediaan,
                'jenis_transaksi' => 'KELUAR', // Ditandai KELUAR karena stok berkurang
                'keterangan'      => 'Retur Sediaan: ' . $alasanRetur,
                'jumlah'          => $jumlahRetur,
                'stok_awal'       => $stokAwalGlobal,  // Saldo global sebelum retur
                'stok_akhir'      => $stokAkhirGlobal, // Saldo global setelah retur
                'user_id'         => auth()->id() ?? null, // Siapa yang melakukan retur
                'tanggal_log'     => now()->toDateString(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Jika semua langkah aman, kunci perubahan ke Database
            DB::commit();

            return response()->json([
                'kode' => 200,
                'message' => 'Berhasil! Data retur sediaan sebanyak ' . $jumlahRetur . ' barang telah diproses dan stok telah diperbarui.'
            ]);
        } catch (\Exception $e) {
            // Gagalkan semua perubahan jika di tengah jalan terdapat error SQL
            DB::rollBack();

            return response()->json([
                'kode' => 500,
                'message' => 'Gagal memproses retur sediaan. Terjadi kesalahan internal: ' . $e->getMessage()
            ]);
        }
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
        $lastRecord = DB::table('mt_barang')
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
    public function generateNoRM($alamat)
    { // 1. Ambil ID Desa berdasarkan alamat_ktp pasien baru
        $desa = DB::table('tabel_master_desa_baru')
            ->where('nama_desa', $alamat)
            ->first();

        if (!$desa) {
            // Handle jika desa tidak ditemukan
            return response()->json(['error' => 'Desa tidak terdaftar'], 404);
        }

        $idDesa = str_pad($desa->prefix, 3, '0', STR_PAD_LEFT); // Hasil: 001

        // 2. Cari nomor RM terakhir yang diawali dengan ID Desa tersebut
        $lastRM = DB::table('master_pasien')
            ->where('nomor_rm', 'like', $idDesa . '-%')
            ->orderBy('nomor_rm', 'desc')
            ->first();

        if ($lastRM) {
            // Ambil bagian nomor urut setelah tanda '-' (misal dari 001-00005 ambil 00005)
            // explode digunakan agar lebih aman jika panjang ID desa berubah
            $parts = explode('-', $lastRM->nomor_rm);
            $noUrutTerakhir = end($parts);
            $nextUrut = str_pad((int)$noUrutTerakhir + 1, 5, '0', STR_PAD_LEFT);
        } else {
            // Jika ini adalah pasien pertama dari desa tersebut
            $nextUrut = '00001';
        }

        // 3. Gabungkan menjadi format 001-00001
        $nomorRMBaru = $idDesa . '-' . $nextUrut;
        return $nomorRMBaru;
    }
    public function sinkronisasirm()
    {
        $sinc = db::select("WITH PasienBerurut AS (
            SELECT 
                mp.id, 
                mdb.prefix,
                -- Membuat nomor urut otomatis per desa (dimulai dari 1 s.d jumlah pasien di desa tersebut)
                ROW_NUMBER() OVER (
                    PARTITION BY mdb.nama_desa -- Dikomparasi per desa agar urutan akurat per jumlah pasien desa
                    ORDER BY mp.id -- Pasien yang mendaftar duluan mendapat nomor urut lebih kecil
                ) as nomor_urut
            FROM master_pasien mp
            INNER JOIN tabel_master_desa_baru mdb 
                ON mp.alamat_ktp = mdb.nama_desa 
        )
        UPDATE master_pasien mp
        INNER JOIN PasienBerurut pb ON mp.id = pb.id
        SET mp.nomor_rm = CONCAT(pb.prefix, '-', LPAD(pb.nomor_urut, 5, '0'));");
        $data2 = [
            'kode' => 200,
            'message' => 'sinkronisasi data pasien berhasil ...'
        ];
        echo json_encode($data2);
        die;
    }
}
