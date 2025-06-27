<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HasilController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('priority', 'asc')->get();

        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');

        $tahun_ajaran = request('tahun_ajaran', $tahunAjarans->first());

        $data = [];
        $status = []; // <-- TAMBAHKAN INI
        foreach ($jurusans as $jurusan) {
            // Data hasil per jurusan, difilter tahun ajaran dan diurutkan berdasarkan Qi tertinggi
            $data[$jurusan->id] = Hasil::where('jurusan_id', $jurusan->id)
                ->whereHas('mahasiswa', function ($query) use ($tahun_ajaran) {
                    $query->where('tahun_ajaran', $tahun_ajaran);
                })
                ->orderBy('qi', 'desc') // ⬅️ Tambahkan ini untuk urut ranking
                ->paginate(10);

            // Ambil status dari hasil pertama
            $status[$jurusan->id] = Hasil::where('jurusan_id', $jurusan->id)
                ->whereHas('mahasiswa', function ($query) use ($tahun_ajaran) {
                    $query->where('tahun_ajaran', $tahun_ajaran);
                })
                ->first()?->status ?? 0;
        }

        // KIRIM STATUS KE VIEW JUGA
        return view('pages.hasil.index', compact('jurusans', 'data', 'tahunAjarans', 'tahun_ajaran', 'status'));
    }

    public function approve($jurusan_id)
    {
        $tahun_ajaran = request('tahun_ajaran');

        $updated = Hasil::where('jurusan_id', $jurusan_id)
            ->whereHas('mahasiswa', function ($query) use ($tahun_ajaran) {
                $query->where('tahun_ajaran', $tahun_ajaran);
            })
            ->update(['status' => 1]);

        return redirect()->back()->with('success', 'Hasil berhasil disetujui!');
    }


    function export(Request $request)
    {
        $jurusan = Jurusan::findOrFail($request->jurusan);
        $data = Hasil::query()->where('jurusan_id', $request->jurusan)->orderBy('rank', 'asc')->get();
        $pdf = Pdf::loadView('pdf.export', ['data' => $data, 'jurusan' => $jurusan]);
        return $pdf->download('hasilPerankingan-' . $jurusan->nama . '.pdf');
    }
}
