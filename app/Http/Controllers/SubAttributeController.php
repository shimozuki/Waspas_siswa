<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Jurusan;
use App\Models\Nilai;
use App\Models\SubAttribute;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubAttributeController extends Controller
{
    public function index()
    {
        $data = SubAttribute::query()->with('jurusan', 'attribute', 'nilai')->paginate(10);
        return view('pages.sub-attribute.index', compact('data'));
    }

    public function create()
    {
        $jurusan = Jurusan::query()->get();
        $attributes = Attribute::query()->get();
        $nilai = Nilai::query()->get();
        return view('pages.sub-attribute.create', compact('jurusan', 'attributes', 'nilai'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => ['required'],
            'attribute_id' => ['required'],
            'nilai_id' => ['required']
        ]);

        SubAttribute::create($validated);
        return redirect()->route('sub-attribute.index')->with('success', 'Sub Kriteria berhasil ditambahkan!');
    }

    public function destroy(Request $request)
    {
        $subAttribute = SubAttribute::findOrFail($request->id);
        try{
            $subAttribute->delete();
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
