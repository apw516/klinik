<div class="card">
    <div class="card-header">Detail Kunjungan Pasien</div>
    <div class="card-body">
        <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($data->tgl_masuk)->translatedFormat('d F Y') }}</p>
        <p><strong>Kunjungan ke :</strong> {{ $data->counter }}</p>
        <p><strong>Nomor RM:</strong> {{ $data->nomor_rm }}</p>
        <p><strong>Nama Dokter:</strong> {{ $data->nama_dokter }}</p>
        <p><strong>Unit/Poli:</strong> {{ $data->nama_unit }}</p>
        <p><strong>Tekanan darah :</strong> {{ $data->tekanan_darah }} mmHg</p>
        <p><strong>Suhu Tubuh:</strong> {{ $data->suhu_tubuh }} (°C)</p>
        <p><strong>Keluhan utama :</strong> {{ $data->keluhan_utama }}</p>
    </div>
</div>
<div hidden class="card">
    <div class="card-header">Billing Pelayanan</div>
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead>
                <th>Kode Ly header</th>
                <th>Tgl entry</th>
                <th>Tgl Layanan</th>
                <th>Nama Tarif </th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($ly as $l)
                    <tr>
                        <td>{{ $l->kode_layanan_header }}</td>
                        <td>{{ \Carbon\Carbon::parse($l->tgl_entry)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($l->tgl_layanan)->format('d-m-Y') }}</td>
                        <td>{{ $l->nama_tarif }}</td>
                        <td>{{ $l->jumlah }}</td>
                        <td>{{ number_format($l->subtotal, 0, 0) }}</td>
                        <td>
                            @if ($l->status_bayar == 1)
                                Sudah dibayar
                            @else
                                Belum dibayar
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
