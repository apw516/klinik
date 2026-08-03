<label for="exampleFormControlInput1" class="form-label">Keluhan Utama</label>
<div class="input-group mb-3">
    <textarea rows="5" type="text" class="form-control" placeholder="masukan keluhan pasien ..."
        aria-label="Recipient’s username" aria-describedby="basic-addon2" name="keluhanutama" name="keluhanutama">@foreach ($data as $item){{ $item->keluhan_utama}} @endforeach
</textarea>
</div>
<label for="" class="mb-2">Pilih Status Kunjungan</label>
<select class="form-select" aria-label="Default select example" id="status_kunjungan">
    @foreach ($data as $item)
        <option value="0" @if ($item->status_kunjungan == 0) selected @endif>Silahkan Pilih</option>
        <option value="1" @if ($item->status_kunjungan == 1) selected @endif>Aktif</option>
        <option value="2" @if ($item->status_kunjungan == 2) selected @endif>Selesai</option>
        <option value="3" @if ($item->status_kunjungan == 3) selected @endif>Batal</option>
    @endforeach
</select>
<input hidden type="text" value="{{ $id }}" id="idkunjungan">
