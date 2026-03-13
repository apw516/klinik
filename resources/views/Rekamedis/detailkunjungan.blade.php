<div class="card">
    <div class="card-header">Detail Kunjungan Pasien</div>
    <div class="card-body">
        <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($data->tgl_masuk)->translatedFormat('d F Y') }}</p>
        <p><strong>Kunjungan ke :</strong> {{ $data->counter }}</p>
        <p><strong>Nomor RM:</strong> {{ $data->nomor_rm }}</p>
        <p><strong>Nama Dokter:</strong> {{ $data->nama_dokter }}</p>
        <p><strong>Unit/Poli:</strong> {{ $data->nama_unit }}</p>
        <p><strong>Tekanan darah :</strong> {{ $data->tekanan_darah}} mmHg</p>
        <p><strong>Suhu Tubuh:</strong> {{ $data->suhu_tubuh}} (°C)</p>
        <p><strong>Keluhan utama :</strong> {{ $data->keluhan_utama}}</p>
    </div>
</div>
