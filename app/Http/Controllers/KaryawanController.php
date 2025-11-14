<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:karyawan,email',
            'jabatan' => 'required',
            'telepon' => 'required|unique:karyawan,telepon',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ]);

        $data = $request->all();

        // jika ada foto yg diupload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . "_" .$file->getClientOriginalName();
            $file->move(public_path('upload/karyawan'), $filename);
            $data['foto'] = $filename;
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:karyawan,email,' .$id,
            'jabatan' => 'required',
            'telepon' => 'required|unique:karyawan,telepon,' .$id,
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ]);
        
        $karyawan = Karyawan::findOrFail($id);
        $data = $request->all();

        // jika ada foto yg diupload
        if ($request->hasFile('foto')) {
            if ($karyawan->foto && file_exists(public_path('upload/karyawan/'. $karyawan->foto))) {
                unlink(public_path('upload/karyawan/'. $karyawan->foto));
            }

            $file = $request->file('foto');
            $filename = time() . "_" .$file->getClientOriginalName();
            $file->move(public_path('upload/karyawan'), $filename);
            $data['foto'] = $filename;
        }

        $karyawan->update($data);
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->foto && file_exists(public_path('upload/karyawan/'. $karyawan->foto))) {
            unlink(public_path('upload/karyawan/'. $karyawan->foto));
        }

        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $karyawan = Karyawan::all();
        $pdf = PDF::loadView('karyawan.download', compact('karyawan'))
        ->setPaper('a4','potrait');

        return $pdf->stream('data_karyawan.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }
}
