<table class="table table-sm table-bordered table-hover">
    <thead>
        <th>No Batch</th>
        <th>ED</th>
        <th>Stok Awal</th>
        <th>Stok Sekarang</th>
        <th>Harga Beli</th>
        <th>Tanggal entry</th>
    </thead>
    <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{ $d->no_batch }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_ed)->translatedFormat('d F Y') }}</td>
                <td>{{ $d->stok_awal}} {{ $d->satuan_kecil}}</td>
                <td>{{ $d->stok_now}} {{ $d->satuan_kecil}}</td>
                <td>{{ number_format($d->hg,0,0 )}}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_entry)->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>