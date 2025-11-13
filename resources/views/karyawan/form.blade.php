<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $karyawan->nama ?? '') }}">
</div>
<div class="mb-3">
    <label>Jabatan</label>
    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan ?? '') }}">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $karyawan->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label>Telepon</label>
    <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $karyawan->telepon ?? '') }}">
    @error('telepon')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label>Foto</label>
    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
    @error('foto')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    @if(isset($karyawan) && $karyawan->foto)
        <div class="mt-2">
            <img src="{{ asset('upload/karyawan/' . $karyawan->foto) }}" alt="Foto Karyawan" width="100" class="rounded">
        </div>
    @endif
</div>
