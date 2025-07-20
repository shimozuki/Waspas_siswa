<?php

namespace App\Http\Controllers;

use App\Models\Kuota;
use Illuminate\Http\Request;

class KuotaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|unique:kuotas,tahun_ajaran',
            'jumlah' => 'required|integer|min:1',
        ]);

        Kuota::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Kuota berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|unique:kuotas,tahun_ajaran,' . $id,
            'jumlah' => 'required|integer|min:1',
        ]);

        $kuota = Kuota::findOrFail($id);
        $kuota->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Kuota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kuota = Kuota::findOrFail($id);
        $kuota->delete();

        return redirect()->back()->with('success', 'Kuota berhasil dihapus.');
    }
}
