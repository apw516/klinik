<table class="table table-sm table-hover" id="tabelantrian">
    <thead>
        <th>Tanggal Antrian</th>
        <th>Nomor Antrian</th>
        <th>Nomor Urut</th>
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Unit Tujuan</th>
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tgl_antri)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $item->nomor_antrian }}</td>
                <td>{{ $item->nomor_urut }}</td>
                <td>{{ $item->nomor_rm }}</td>
                <td>{{ $item->nama_pasien }}</td>
                <td>{{ $item->nama_unit }}</td>
                <td>
                    @if ($item->status == 1)
                        belum dipanggil
                    @elseif($item->status == 2)
                        sedang dilayani
                    @elseif($item->status == 3)
                        Farmasi / Pembayaran
                    @elseif($item->status == 4)
                        Selesai
                    @elseif($item->status == 5)
                        Batal
                    @endif
                </td>
                <td>
                    <button @if($item->status == 5) disabled @endif class="btn btn-sm <button @if($item->status == 5) btn-danger @else btn-success @endif  updatastatus" idantrian="{{ $item->id }}"><i
                            class="bi bi-telephone-forward-fill"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaleditantrian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status Antrian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_status">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="simpaneditstatus()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelantrian").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".updatastatus").on('click', function(event) {
        idantrian = $(this).attr('idantrian')
        $('#modaleditantrian').modal('show');
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idantrian
            },
            url: '<?= route('ambilformupdateantrian') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_status').html(response);
            }
        });
    });

    function simpaneditstatus() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "status antrian akan diedit !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, edit !"
        }).then((result) => {
            if (result.isConfirmed) {
                status = $('#status_antrian').val()
                id = $('#idantrian').val()
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id,
                        status
                    },
                    url: '<?= route('simpaneditstatusantrian') ?>',
                    error: function(data) {
                        spinner.hide()
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops....',
                            text: 'Sepertinya ada masalah......',
                            footer: ''
                        })
                    },
                    success: function(data) {
                        spinner.hide()
                        if (data.kode == 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: data.message,
                                footer: ''
                            })
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'OK',
                                text: data.message,
                                footer: ''
                            })
                            location.reload()
                        }
                    }
                });
            }
        });
    }
</script>
