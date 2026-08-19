<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="bi bi-person-lines-fill fs-5"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold text-dark">Detail Kunjungan Pasien</h5>
                <small class="text-muted">Informasi rekam medis dan ringkasan klinis periksa</small>
            </div>
        </div>
        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold">
            Kunjungan Ke-{{ $data->counter }}
        </span>
    </div>
    <div class="card-body p-4">
        <div class="row g-3 mb-4 bg-light rounded-3 p-3 border mx-0">
            <div class="col-md-3">
                <small class="text-muted d-block text-uppercase fw-bold style-label">Nomor Rekam Medis</small>
                <span class="text-dark fw-bold h5 mb-0">{{ $data->nomor_rm }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block text-uppercase fw-bold style-label">Nama Dokter</small>
                <span class="text-dark fw-semibold mb-0">{{ $data->nama_dokter }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block text-uppercase fw-bold style-label">Unit / Poli Pelayanan</small>
                <span class="badge bg-primary px-2.5 py-1.5 rounded text-uppercase">{{ $data->nama_unit }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block text-uppercase fw-bold style-label">Tanggal Masuk</small>
                <span class="text-dark mb-0 fw-medium">
                    <i class="bi bi-calendar3 text-muted me-1"></i>
                    {{ \Carbon\Carbon::parse($data->tgl_masuk)->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>

        <h6 class="fw-bold text-secondary text-uppercase mb-3 d-flex align-items-center"
            style="font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="bi bi-heart-pulse-fill text-danger me-2"></i> Tanda-Tanda Vital & Usia
        </h6>
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-secondary-subtle text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-person-bounding-box fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Usia Pasien</small>
                        <span class="fw-bold text-dark fs-6">{{ $data->usia_kunjungan ?? ($data->umur ?? '-') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-activity fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Tekanan Darah</small>
                        <span class="fw-bold text-dark fs-5">{{ $data->tekanan_darah }} <small
                                class="fs-6 text-muted fw-normal">mmHg</small></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-danger-subtle text-danger rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-thermometer-half fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Suhu Tubuh</small>
                        <span class="fw-bold text-dark fs-5">{{ $data->suhu_tubuh }} <small
                                class="fs-6 text-muted fw-normal">°C</small></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-warning-subtle text-warning-inverse rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-heart fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Frekuensi Nadi</small>
                        <span class="fw-bold text-dark fs-5">{{ $data->frekuensi_nadi ?? '-' }} <small
                                class="fs-6 text-muted fw-normal">x/mnt</small></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-wind fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Frekuensi Nafas</small>
                        <span class="fw-bold text-dark fs-5">{{ $data->frekuensi_nafas ?? '-' }} <small
                                class="fs-6 text-muted fw-normal">x/mnt</small></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2.4">
                <div class="p-3 border rounded-3 bg-white h-100 shadow-xs d-flex align-items-center">
                    <div class="bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-droplet-half fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Saturasi Oksigen</small>
                        <span class="fw-bold text-dark fs-5">{{ $data->saturasi_oksigen ?? '-' }} <small
                                class="fs-6 text-muted fw-normal">%</small></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="p-3 border rounded-3 bg-white h-100">
                    <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Keluhan
                        Utama</small>
                    <p class="text-dark fw-medium mb-0 text-break" style="line-height: 1.5;">
                        {{ $data->keluhan_utama ?: '-' }}</p>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="p-3 border rounded-3 bg-white h-100">
                    <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Hasil Laboratorium / Penunjang</small>
                    <p class="text-dark fw-medium mb-0 text-break" style="line-height: 1.5;">{{ $data->pemeriksaan_penunjang ?: 'Tidak ada pemeriksaan penunjang.' }}</p>
                </div>
            </div> --}}
        </div>

        <h6 class="fw-bold text-secondary text-uppercase mb-3 d-flex align-items-center"
            style="font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="bi bi-file-earmark-medical-fill text-primary me-2"></i> Ringkasan Pemeriksaan SOAP
        </h6>
        <div class="border rounded-3 bg-white overflow-hidden mb-5 shadow-xs">
            <div class="d-flex border-bottom app-soap-row">
                <div class="bg-light fw-bold text-center border-end p-3 d-flex align-items-center justify-content-center text-primary"
                    style="width: 140px; min-width: 140px;">
                    SUBJECT (S)
                </div>
                <div class="p-3 text-dark text-break fw-medium flex-grow-1">{{ $data->SUBJECT ?: '-' }}</div>
            </div>
            <div class="d-flex border-bottom app-soap-row">
                <div class="bg-light fw-bold text-center border-end p-3 d-flex align-items-center justify-content-center text-success"
                    style="width: 140px; min-width: 140px;">
                    OBJECT (O)
                </div>
                <div class="p-3 text-dark text-break fw-medium flex-grow-1">{{ $data->OBJECT ?: '-' }}</div>
            </div>
            <div class="d-flex border-bottom app-soap-row">
                <div class="bg-light fw-bold text-center border-end p-3 d-flex align-items-center justify-content-center text-warning"
                    style="width: 140px; min-width: 140px;">
                    ASSESSMENT (A)
                </div>
                <div class="p-3 text-dark text-break fw-bold flex-grow-1 text-primary">{{ $data->ASSESMENT ?: '-' }}
                </div>
            </div>
            <div class="d-flex app-soap-row">
                <div class="bg-light fw-bold text-center border-end p-3 d-flex align-items-center justify-content-center text-info"
                    style="width: 140px; min-width: 140px;">
                    PLANNING (P)
                </div>
                <div class="p-3 text-dark text-break fw-medium flex-grow-1">{{ $data->PLANNING ?: '-' }}</div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between border-bottom">
                <h6 class="m-0 fw-bold text-secondary">
                    <i class="bi bi-receipt-cutoff text-primary me-2"></i>Rincian Billing & Sediaan Pasien
                </h6>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold"
                    style="font-size: 0.8rem;">
                    {{ count($layanan) }} Item Terinput
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                        <thead class="table-light text-uppercase tracking-wider" style="font-size: 0.75rem;">
                            <tr>
                                <th class="text-center py-3" style="width: 5%;">No</th>
                                <th class="py-3" style="width: 35%;">Nama Layanan / Obat</th>
                                <th class="text-center py-3" style="width: 15%;">Jenis</th>
                                <th class="text-center py-3" style="width: 10%;">Qty</th>
                                <th class="py-3" style="width: 23%;">Catatan / Aturan Pakai</th>
                                {{-- <th class="text-center py-3" style="width: 12%;">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanan as $l)
                                <tr
                                    class="{{ $l->status_layanan == 3 ? 'table-light text-muted text-decoration-line-through' : '' }}">
                                    <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $l->nama_tarif }}</div>
                                        @if ($l->kode_barang && $l->kode_barang != '0')
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                <i class="bi bi-box-seam me-1"></i>Kode: {{ $l->kode_barang }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($l->kode_barang == '0' || empty($l->kode_barang))
                                            <span
                                                class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2.5 py-1">
                                                <i class="bi bi-heart-pulse-fill me-1"></i>Tindakan/Jasa
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1">
                                                <i class="bi bi-capsule me-1"></i>Obat/Alkes
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold fs-6">
                                        {{ number_format($l->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($l->status_layanan == 3)
                                            <span class="text-danger small fw-semibold"><i
                                                    class="bi bi-x-circle-fill me-1"></i>Item ini telah
                                                diretur/dibatalkan</span>
                                        @else
                                            <span
                                                class="text-secondary">{{ $l->aturan_pakai ?? ($l->keterangan ?? '-') }}</span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">
                                        @if ($l->status_layanan != 3)
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-retur-billing px-2.5 py-1 rounded-2"
                                                data-id="{{ $l->id }}" data-nama="{{ $l->nama_tarif }}"
                                                title="Retur Item">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Retur
                                            </button>
                                        @else
                                            <span
                                                class="badge bg-secondary-subtle text-secondary rounded-1 px-2 py-1">Selesai</span>
                                        @endif
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x d-block fs-2 mb-2 text-secondary"></i>
                                        Belum ada data rincian transaksi billing untuk pasien ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h6 class="fw-bold text-secondary text-uppercase mb-0 d-flex align-items-center"
                        style="font-size: 0.8rem; letter-spacing: 0.5px;">
                        <i class="fas fa-file-invoice-dollar text-primary mr-2" style="font-size: 1.1rem;"></i>
                        Hasil Pemeriksaan Laboratorium
                    </h6>

                    {{-- Ganti $hasillab->kode_kunjungan sesuai dengan variabel data kunjungan Anda --}}
                    <button class="btn btn-sm btn-success px-3 shadow-sm"
                        onclick="printLaboratorium('{{ $hasillab->kode_kunjungan ?? '' }}')">
                        <i class="fas fa-print mr-1"></i> Cetak Hasil
                    </button>
                </div>
            </div>
            <div class="card-body">
                <style>
                    /* CSS Kustom agar Input Menyatu Sempurna dengan Tabel */
                    .table-input-seamless {
                        vertical-align: middle !important;
                    }

                    .table-input-seamless td {
                        padding: 4px 8px !important;
                        /* Memperkecil padding agar tabel lebih ringkas */
                        vertical-align: middle !important;
                    }

                    .table-input-seamless .input-group {
                        margin-bottom: 0 !important;
                        /* Menghilangkan margin bawaan bootstrap */
                        border: 1px solid #dee2e6;
                        /* Membuat border luar membungkus input + satuan */
                        border-radius: 4px;
                        background-color: #fff;
                        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                    }

                    /* Efek Fokus saat User Mengklik Kolom Hasil */
                    .table-input-seamless .input-group:focus-within {
                        border-color: #80bdff;
                        outline: 0;
                        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                    }

                    .table-input-seamless .form-control-minimal {
                        border: none !important;
                        /* Menghapus border internal input */
                        background-color: transparent !important;
                        padding: 4px 8px;
                        height: auto;
                        text-align: right;
                        /* Angka hasil lab umumnya rata kanan */
                        font-weight: 600;
                        color: #495057;
                    }

                    .table-input-seamless .form-control-minimal:focus {
                        box-shadow: none !important;
                        outline: none !important;
                    }

                    .table-input-seamless .unit-text {
                        border: none !important;
                        /* Menghapus border internal addon */
                        background-color: transparent !important;
                        color: #6c757d;
                        font-size: 0.85rem;
                        padding-left: 4px;
                        padding-right: 8px;
                    }
                </style>
                <div class="border rounded-3 bg-white overflow-hidden mb-5 shadow-xs">
                    <table class="table table-sm table-bordered table-input-seamless">
                        <thead class="bg-light text-center">
                            <tr>
                                <th class="align-middle">JENIS PEMERIKSAAN</th>
                                <th class="align-middle" rowspan="2" style="width: 25%;">HASIL</th>
                                <th class="align-middle" rowspan="2" colspan="2">NILAI RUJUKAN</th>
                            </tr>
                            <tr>
                                <th class="text-left text-primary fw-bold">HEMATOLOGI RUTIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Hemoglobin Rutin</td>
                                <td>
                                    <div class="input-group">
                                        {{-- 
                        Menggunakan Null Coalescing Operator (??) untuk mengisi value.
                        Jika $hasillab ada nilainya, tampilkan hb_hasil. Jika kosong, isi dengan string kosong ''.
                    --}}
                                        <input readonly type="text" name="hb_hasil"
                                            class="form-control form-control-minimal" placeholder="0.0"
                                            value="{{ $hasillab->hb_hasil ?? '' }}">
                                        <span class="input-group-text unit-text">gr/dl</span>
                                    </div>
                                </td>
                                <td>P : 12 – 15,5 gr/dl</td>
                                <td>L : 13,5 – 17,5 gr/dl</td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Hematokrit</td>
                                <td>
                                    <div class="input-group">
                                        <input readonly type="text" name="ht_hasil"
                                            class="form-control form-control-minimal" placeholder="0"
                                            value="{{ $hasillab->ht_hasil ?? '' }}">
                                        <span class="input-group-text unit-text">%</span>
                                    </div>
                                </td>
                                <td>P : 34,9 – 44,5%</td>
                                <td>L : 38,8 – 50%</td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Eritrosit</td>
                                <td>
                                    <div class="input-group">
                                        <input readonly type="text" name="eritrosit_hasil"
                                            class="form-control form-control-minimal" placeholder="0.0"
                                            value="{{ $hasillab->eritrosit_hasil ?? '' }}">
                                        <span class="input-group-text unit-text">juta/mm³</span>
                                    </div>
                                </td>
                                <td>P : 4 – 5 Juta/mm³</td>
                                <td>L : 4,5 – 5,5 juta/mm³</td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Leukosit</td>
                                <td>
                                    <div class="input-group">
                                        <input readonly type="text" name="leukosit_hasil"
                                            class="form-control form-control-minimal" placeholder="0"
                                            value="{{ $hasillab->leukosit_hasil ?? '' }}">
                                        <span class="input-group-text unit-text">/µL</span>
                                    </div>
                                </td>
                                <td>P : 4.500 – 10.000 /µL</td>
                                <td>L : 4.500 – 10.000 /µL</td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Trombosit</td>
                                <td>
                                    <div class="input-group">
                                        <input readonly type="text" name="trombosit_hasil"
                                            class="form-control form-control-minimal" placeholder="0"
                                            value="{{ $hasillab->trombosit_hasil ?? '' }}">
                                        <span class="input-group-text unit-text">/µL</span>
                                    </div>
                                </td>
                                <td>P : 150.000 – 450.000 /µL</td>
                                <td>L : 150.000 – 450.000 /µL</td>
                            </tr>

                            <tr class="bg-light">
                                <td colspan="4" class="p-3">
                                    <div class="form-group mb-0">
                                        <label for="hasillab"
                                            class="fw-bold text-secondary small mb-1.5 d-flex align-items-center">
                                            <i class="fas fa-comment-medical text-primary mr-2"
                                                style="font-size: 1.1rem;"></i>
                                            KESAN / INTERPRETASI LABORATORIUM
                                        </label>
                                        <textarea readonly class="form-control border-secondary-subtle rounded-2 p-2.5" rows="4" id="hasillab"
                                            name="kesan_lab" placeholder="Tuliskan kesan atau catatan keahlian dokter/petugas laboratorium di sini...">{{ $hasillab->kesan_lab ?? '' }}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- INFORMASI TAMBAHAN STATUS DATA DI BAWAH TABEL --}}
                    <div class="mt-2 text-right">
                        @if (empty($hasillab))
                            <small class="text-muted font-italic">
                                <i class="fas fa-info-circle text-warning"></i> Pasien belum memiliki riwayat input lab
                                untuk kunjungan ini. Form akan membuat data baru saat disimpan.
                            </small>
                        @else
                            <small class="text-success font-weight-bold">
                                <i class="fas fa-check-circle"></i> Menampilkan data simpanan terakhir (Terakhir
                                diperbarui: {{ \Carbon\Carbon::parse($hasillab->tgl_entry)->format('d-m-Y H:i') }}
                                WIB)
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- <h6 class="fw-bold text-secondary text-uppercase mb-3 d-flex align-items-center" style="font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="bi bi-receipt-cutoff text-success me-2"></i> Rincian Billing Pelayanan & Tindakan
        </h6>
        <div class="table-responsive border rounded-3 bg-white shadow-xs">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-3 py-3">Kode Header</th>
                        <th class="py-3">Tgl Entry</th>
                        <th class="py-3">Tgl Layanan</th>
                        <th class="py-3">Nama Tarif / Tindakan</th>
                        <th class="py-3 text-center">Jumlah</th>
                        <th class="py-3 text-end">Total (Rp)</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="pe-3 py-3 text-center" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ly as $l)
                        <tr>
                            <td class="ps-3 fw-semibold text-secondary">{{ $l->kode_layanan_header }}</td>
                            <td>{{ \Carbon\Carbon::parse($l->tgl_entry)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($l->tgl_layanan)->format('d-m-Y') }}</td>
                            <td class="fw-semibold text-dark">{{ $l->nama_tarif }}</td>
                            <td class="text-center">{{ $l->jumlah }}</td>
                            <td class="text-end fw-bold text-dark">{{ number_format($l->subtotal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if ($l->status_bayar == 1)
                                    <span class="badge bg-success-subtle text-success px-2 py-1.5 rounded border border-success-subtle">Lunas</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1.5 rounded border border-danger-subtle">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="pe-3 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-2 returlayanan" 
                                    {{ $l->status_bayar == 1 ? 'disabled' : '' }}
                                    iddetail="{{ $l->iddetail }}" 
                                    nama="{{ $l->nama_tarif }}"
                                    data-bs-toggle="tooltip" 
                                    title="Batalkan Layanan">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i> Belum ada billing tindakan medis tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}

    </div>
</div>
<script>
    $(document).ready(function() {
        // Inisialisasi tooltip Bootstrap jika dipakai
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        $(".returlayanan").on('click', function(event) {
            event.preventDefault();
            var nama = $(this).attr('nama');
            var iddetail = $(this).attr('iddetail');

            Swal.fire({
                title: "Pembatalan Tindakan",
                text: "Apakah Anda yakin akan membatalkan layanan " + nama + " ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Batalkan !",
                cancelButtonText: "Kembali"
            }).then((result) => {
                if (result.isConfirmed) {
                    var spinner = $('#loader');
                    spinner.show();

                    $.ajax({
                        async: true,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            iddetail: iddetail
                        },
                        url: '{{ route('returlayanan') }}',
                        error: function(data) {
                            spinner.hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Sistem Terkendala',
                                text: 'Gagal memproses pembatalan, silakan hubungi tim IT.',
                            });
                        },
                        success: function(data) {
                            spinner.hide();
                            if (data.kode == 500) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#modaldetail').modal('hide');
                                tampilkandatapasien();
                            }
                        }
                    });
                }
            });
        });
    });

    function printLaboratorium(kodeKunjungan) {
        // Validasi awal jika data kunjungan kosong
        if (!kodeKunjungan || kodeKunjungan === '') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mencetak',
                text: 'Kode kunjungan tidak valid atau belum tersimpan.',
                footer: 'ermwaled2026'
            });
            return false;
        }

        // Aktifkan loading spinner rumah sakit
        let spinner = $('#loader');
        if (spinner.length) spinner.show();

        // Jalankan AJAX untuk mengecek kesiapan berkas di Controller
        $.ajax({
            type: 'POST',
            url: '<?= route('cek_kesiapan_cetak_lab') ?>', // Sesuaikan nama route Anda
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan: kodeKunjungan
            },
            error: function() {
                if (spinner.length) spinner.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Gagal menghubungi server penyedia dokumen.',
                    footer: 'ermwaled2026'
                });
            },
            success: function(response) {
                if (spinner.length) spinner.hide();

                // Jika server menyatakan data lab siap / valid
                if (response.status === 'success' || response.kode == 200) {

                    // Buka link dokumen cetak PDF yang dikirim oleh controller di tab baru
                    window.open(response.url_cetak, '_blank');

                } else {
                    // Jika data kosong atau belum diisi oleh petugas lab
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dokumen Belum Siap',
                        text: response.message ||
                            'Data hasil pemeriksaan laboratorium masih kosong.',
                        footer: 'ermwaled2026'
                    });
                }
            }
        });
    }
</script>
