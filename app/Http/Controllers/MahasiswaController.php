<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Attribute;
use App\Models\Mahasiswa;
use App\Models\NilaiSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Excel as ExcelFormat;

class MahasiswaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $mahasiswas = Mahasiswa::query();
            return DataTables::eloquent($mahasiswas)
                ->addColumn('edit', '<a href="{{route("mahasiswa.show", $id)}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white mr-2">
                <i class="fa-solid fa-eye"></i></a><button onclick="showModals({{$id}})" class="btn bg-red-600 hover:bg-red-700 text-white">
                <i class="fa-solid fa-trash"></i></button>')
                ->rawColumns(['edit'])
                ->make();
        }
        return view('pages.mahasiswa.index');
    }

    function create()
    {
        return view('pages.mahasiswa.create');
    }

    public function save(Request $request)
    {
        $kriteria = Attribute::all();
        if ($kriteria->isEmpty()) {
            return redirect()->back()->with('error', 'Data Kriteria belum ada!');
        }

        $request->validate([
            'excel' => ['required', 'file', 'mimes:xlsx,xls,csv']
        ]);

        try {
            $import = new SiswaImport;
            Excel::import($import, $request->file('excel'));

            $hasil = $import->getHasil();

            $pesan = "";

            if ($hasil['gagal'] > 0) {
                $pesan .= " ❌ {$hasil['gagal']} gagal. Periksa log untuk detail.";
                Log::warning("Log Gagal Import:\n" . implode("\n", $hasil['log']));
                return redirect()->route('mahasiswa.index')->with('error', $pesan);
            }

            return redirect()->route('mahasiswa.index')->with('success', $pesan);
        } catch (\Exception $e) {
            Log::error('❌ Gagal impor Excel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat impor data.');
        }
    }


    function show($id)
    {
        $mahasiswa = Mahasiswa::with('nilaiSiswa.attribute')->find($id);
        $nilaiSiswa = NilaiSiswa::select('attributes.nama as attribute_nama', 'nilai_siswas.poin')
            ->join('nilais', 'nilai_siswas.nilai_id', '=', 'nilais.id')
            ->join('attributes', 'nilais.attribute_id', '=', 'attributes.id')
            ->where('nilai_siswas.mahasiswa_id', $id)
            ->get();
        return view('pages.mahasiswa.show', compact('mahasiswa', 'nilaiSiswa'));
    }

    function destroy(Request $request): void
    {
        $mahasiswa = Mahasiswa::findOrFail($request->id);
        NilaiSiswa::where('mahasiswa_id', $mahasiswa->id)->delete();
        $mahasiswa->delete();
    }
}
