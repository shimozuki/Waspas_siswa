<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $attributes = Jurusan::query()->orderBy('priority', 'asc');
            return DataTables::eloquent($attributes)
                ->addColumn('edit', '<a href="{{route("jurusan.edit", $id)}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white mr-2">
                <i class="fa-solid fa-edit"></i></a><button onclick="showModals({{$id}})" class="btn bg-red-600 hover:bg-red-700 text-white">
                <i class="fa-solid fa-trash"></i></button>')
                ->rawColumns(['edit'])
                ->make();
        }
        return view('pages.jurusan.index');
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::query()->count();
        $jurusan = Jurusan::query()->sum('quota');
        $totalMax = $mahasiswa - $jurusan;
        if($totalMax == 0){
            return redirect()->route('jurusan.index')->with('error', 'Kuota Sudah penuh!');
        }
        return view('pages.jurusan.create', compact('totalMax'));
    }

    public function save(Request $request)
    {
        $mahasiswa = Mahasiswa::query()->count();
        $jurusan = Jurusan::query()->sum('quota');
        $totalMax = $mahasiswa - $jurusan;
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'numeric', 'unique:jurusans,priority'],
            'quota' => ['required', 'numeric', 'max:'. $totalMax]
        ]);

        Jurusan::create($validated);
        return redirect()->route('jurusan.index')->with('success', 'Jurusan Berhasil ditambah!');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::query()->count();
        $jurusan = Jurusan::query()->where('id', '!=', $id)->sum('quota');
        $totalMax = $mahasiswa - $jurusan;
        $jurusan = Jurusan::findOrFail($id);
        return view('pages.jurusan.edit', compact('jurusan', 'totalMax'));
    }

    public function update($id, Request $request)
    {
        $mahasiswa = Mahasiswa::query()->count();
        $jurusan = Jurusan::query()->where('id', '!=', $id)->sum('quota');
        $totalMax = $mahasiswa - $jurusan;
        $jurusan = Jurusan::findOrFail($id);
        if($jurusan){
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'priority' => ['required', 'numeric', 'unique:jurusans,priority,' . $id],
                'quota' => ['required', 'numeric', 'max:'. $totalMax],
            ]);

            $jurusan->update($validated);
        }
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
    }
}
