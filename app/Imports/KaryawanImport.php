<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class KaryawanImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * Map beberapa kemungkinan nama header -> cari yang ada.
     */
    protected function getCell(array $row, array $keys)
    {
        foreach ($keys as $k) {
            if (isset($row[$k]) && $row[$k] !== null && $row[$k] !== '') {
                return $row[$k];
            }
        }
        return null;
    }

    public function model(array $row)
    {
        // Cek beberapa variasi header untuk keandalan
        $nama = $this->getCell($row, ['nama', 'Nama', 'name', 'Name']);
        $email = $this->getCell($row, ['email', 'Email', 'e-mail']);
        $telepon = $this->getCell($row, ['no_hp', 'no hp', 'nohp', 'phone', 'telepon']);
        $jabatan = $this->getCell($row, ['jabatan', 'Jabatan', 'posisi']);

        // Jika data kosong → skip
        if (!isset($row['nama']) && !isset($row['email'])) {
            return null;
        }

        // Cek duplikasi email
        if (isset($row['email']) && Karyawan::where('email', $row['email'])->exists()) {
            return null; // skip baris
        }

        // Cek duplikasi no_hp
        if (isset($row['telepon']) && Karyawan::where('telepon', $row['telepon'])->exists()) {
            return null; // skip baris
        }


        // Contoh: jika email wajib minimal salah satu identitas harus ada
        return new Karyawan([
            'nama'   => $nama ?? '',
            'email'  => $email ?? null,
            'telepon'  => $telepon ?? null,
            'jabatan' => $jabatan ?? null,
        ]);
    }

    /**
     * Validation rules per kolom (WithHeadingRow otomatis menaruh rules dengan prefix *)
     */
    public function rules(): array
    {
        return [
            '*.email' => 'nullable|email',
            '*.nama' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama.required' => 'Kolom nama wajib diisi.',
            '*.email.email' => 'Format email tidak valid.',
        ];
    }
}
