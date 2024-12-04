<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NilaiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $nilai = Nilai::query();
            return DataTables::eloquent($nilai)
                ->addColumn('edit', '<button onclick="showModals({{$id}})" class="btn bg-red-600 hover:bg-red-700 text-white">
                <i class="fa-solid fa-trash"></i></button>')
                ->rawColumns(['edit'])
                ->make();
        }
        return view('pages.nilai.index');
    }

    public function create()
    {
        return view('pages.nilai.create');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255']
        ]);
        Nilai::create($validated);
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan!');
    }

    public function destroy(Request $request)
    {
        $nilai = Nilai::findOrFail($request->id);
        try{
            $nilai->delete();
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
