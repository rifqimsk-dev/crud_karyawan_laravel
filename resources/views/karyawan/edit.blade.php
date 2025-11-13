@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Karyawan</h2>
    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('karyawan.form')
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
