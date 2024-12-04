<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\NilaiAttribute;
use Illuminate\Http\Request;

class NilaiAttributeController extends Controller
{
    function index()
    {
        $attributes = Attribute::all();
        return view('pages.nilai-attribute.index', compact('attributes'));
    }

    function create($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('pages.nilai-attribute.create', compact('attribute'));    
    }

    function save($id, Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'nilai' => ['required', 'numeric'],
        ]);

        $validated['attribute_id'] = $id;

        NilaiAttribute::create($validated);
        return redirect()->route('nilai-attribute.index')->with('success', 'Nilai Attribute berhasil ditambahkan!');
    }

    function edit($id)
    {
        $nilaiAttribute = NilaiAttribute::findOrFail($id);
        return view('pages.nilai-attribute.edit', compact('nilaiAttribute'));    
    }

    function update($id, Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'nilai' => ['required'],
        ]);

        $nilaiAttribute = NilaiAttribute::findOrFail($id);
        $nilaiAttribute->update($validated);
        return redirect()->route('nilai-attribute.index')->with('success', 'Nilai Attribute berhasil diupdate!');
    }

    function delete(Request $request)
    {
        $id = $request->id;
        $nilaiAttribute = NilaiAttribute::findOrFail($id);
        $nilaiAttribute->delete();
    }
}
