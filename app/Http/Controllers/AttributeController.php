<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $attributes = Attribute::query()->orderBy('kode', 'asc');
            return DataTables::eloquent($attributes)
                ->addColumn('edit', '<a href="{{route("attribute.edit", $id)}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white mr-2">
                <i class="fa-solid fa-edit"></i></a><button onclick="showModals({{$id}})" class="btn bg-red-600 hover:bg-red-700 text-white">
                <i class="fa-solid fa-trash"></i></button>')
                ->rawColumns(['edit'])
                ->make();
        }
        return view('pages.attribute.index');
    }

    function create()
    {
        return view('pages.attribute.create');
    }

    function save(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'unique:attributes'],
            'bobot' => ['required','numeric'],
        ]);

        Attribute::create($validated);

        return redirect()->route('attribute.index')->with('success', 'Kriteria Berhasil ditambahkan!');
    }

    function edit($id) 
    {
        $attribute = Attribute::findOrFail($id);
        return view('pages.attribute.edit', compact('attribute'));
    }

    function update($id, Request $request)
    {
        $attribute = Attribute::findOrFail($id);
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'unique:attributes,kode,' . $attribute->id],
            'bobot' => ['required','numeric'],
        ]);
        $attribute->update($validated);
        return redirect()->route('attribute.index')->with('success', 'Kriteria berhasil diupdate!');
    }

    function delete($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
    }
}
