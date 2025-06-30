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
        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $tahun_ajaran = request('tahun_ajaran', $tahunAjarans->first());

        $data = Hasil::with('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('tahun_ajaran', $tahun_ajaran))
            ->orderByDesc('qi')
            ->paginate(10);

        $status = Hasil::whereHas('mahasiswa', fn($q) => $q->where('tahun_ajaran', $tahun_ajaran))
            ->first()?->status ?? 0;

        return view('pages.hasil.index', compact('data', 'tahunAjarans', 'tahun_ajaran', 'status'));
    }



    public function approve($tahun_ajaran)
    {
        $updated = Hasil::whereHas('mahasiswa', function ($query) use ($tahun_ajaran) {
            $query->where('tahun_ajaran', $tahun_ajaran);
        })->update(['status' => 1]);

        return redirect()->back()->with('success', 'Hasil berhasil disetujui!');
    }


    public function export($tahun_ajaran)
    {
        $data = Hasil::with('mahasiswa')
            ->whereHas('mahasiswa', function ($q) use ($tahun_ajaran) {
                $q->where('tahun_ajaran', $tahun_ajaran);
            })
            ->orderBy('rank', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.export', [
            'data' => $data,
            'tahun_ajaran' => $tahun_ajaran
        ]);

        return $pdf->download('hasilPerankingan-' . $tahun_ajaran . '.pdf');
    }
}
