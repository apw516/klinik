<table class="table table-sm table-hover table-bordered align-middle">
    <thead class="table-secondary text-center">
        <tr>
            <th>No</th>
            <th>Tgl Masuk</th>
            <th>No. RM / Nama Pasien</th>
            <th>Unit Tujuan</th>
            <th>Kode Layanan</th>
            <th>Status Bayar</th>
            <th>Tagihan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $d)
            @if ($d->status_layanan != 3)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($d->tgl_masuk)->format('d-m-Y H:i') }}</td>
                    <td>
                        <span class="fw-bold">{{ $d->nomor_rm }}</span><br>
                        <small class="text-uppercase">{{ $d->nama_pasien }}</small>
                    </td>
                    <td><span class="badge bg-outline-info text-dark border">{{ $d->nama_unit }}</span></td>

                    {{-- Logika Jika Layanan Kosong (Hasil Left Join) --}}
                    @if ($d->kode_layanan_header)
                        <td class="text-center text-primary fw-bold">{{ $d->kode_layanan_header }}</td>
                        <td class="text-center">
                            @if ($d->status_layanan != 3)
                                @if ($d->status_bayar == 1)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lunas</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Belum Bayar</span>
                                @endif
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Batal</span>
                            @endif
                        </td>
                        <td class="text-end fw-bold">
                            Rp {{ number_format($d->total_tagihan, 0, ',', '.') }}
                        </td>
                    @else
                        <td colspan="3" class="text-center text-muted italic small">Belum ada input layanan</td>
                    @endif

                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button title="Detail Kunjungan" class="btn btn-sm btn-info text-white detailtagihan"
                                idtagihan="{{ $d->idlayananheader }}" data-bs-toggle="modal"
                                data-bs-target="#modaldetailtagihan">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="8" class="text-center py-4">Data tidak ditemukan untuk periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetailtagihan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Tagihan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_tagihan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(".detailtagihan").on('click', function(event) {
        idheader = $(this).attr('idtagihan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                idheader
           },
            url: '<?= route('detailtagihan') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(response) {
                spinner.hide()
                if (response.kode == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: response.message,
                        footer: ''
                    })
                } else {
                    $('.v_tagihan').html(response.view);
                }
            }
        });
    })
</script>
