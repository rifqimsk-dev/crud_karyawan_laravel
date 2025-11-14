<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KaryawanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Karyawan::select('nama','email','telepon','jabatan')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Telepon',
            'Jabatan',
        ];
    }
}
