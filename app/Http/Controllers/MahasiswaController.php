<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Attribute;
use App\Models\Mahasiswa;
use App\Models\NilaiSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

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

    function save(Request $request)
    {
        $kriteria = Attribute::query()->get();
        if (count($kriteria) == 0) {
            return redirect()->refresh()->with('error', 'Data Kriteria belum ada!');
        }
        $validated = $request->validate([
            'excel' => ['required', 'mimes:xlsx,xls,csv']
        ]);
        Excel::import(new SiswaImport, $request->file('excel'));
        return redirect()->route('mahasiswa.index')->with('success', 'Data Siswa Berhasil diimport!');
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
