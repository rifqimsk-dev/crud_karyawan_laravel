<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Karyawan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Data Karyawan</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($karyawan as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->telepon }}</td>
            <td>{{ $row->jabatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
