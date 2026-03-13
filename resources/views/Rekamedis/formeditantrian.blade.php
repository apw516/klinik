<label for="" class="mb-2">Pilih Status Antrian</label>
<select class="form-select" aria-label="Default select example" id="status_antrian">
    @foreach ($data as $item)
        <option value="0" @if ($item->status == 0) selected @endif>Silahkan Pilih</option>
        <option value="1" @if ($item->status == 1) selected @endif>belum dipanggil</option>
        <option value="2" @if ($item->status == 2) selected @endif>sedang dilayani</option>
        <option value="3" @if ($item->status == 3) selected @endif>Farmasi / Pembayaran</option>
        <option value="4" @if ($item->status == 4) selected @endif>Selesai</option>
        <option value="5" @if ($item->status == 5) selected @endif>Batal</option>
    @endforeach
</select>
<input hidden type="text" value="{{ $id }}" id="idantrian">