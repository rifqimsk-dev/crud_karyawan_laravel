@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Karyawan</h2>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">+ Tambah Karyawan</a>
    <a href="{{ route('karyawan.export.pdf') }}" target="_blank" class="btn btn-secondary mb-3">Export PDF</a>
    <a href="{{ route('karyawan.export.excel') }}" target="_blank" class="btn btn-success mb-3">Export Excel</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawan as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama }}</td>
                <td>{{ $k->jabatan }}</td>
                <td>{{ $k->email }}</td>
                <td>{{ $k->telepon }}</td>
                <td>
                    <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
