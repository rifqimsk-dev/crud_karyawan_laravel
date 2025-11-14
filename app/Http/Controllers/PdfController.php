<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use PDF;

class PdfController extends Controller
{
    public function exportPdf()
    {
        $karyawan = Karyawan::all();
        $pdf = PDF::loadView('karyawan.pdf', compact('karyawan'))
        ->setPaper('a4','potrait');

        return $pdf->download('data_karyawan.pdf');
    }
}
