<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Jurusan;
use App\Models\Kuota;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HasilController extends Controller
{
    public function index()
    {
        // Ambil daftar tahun ajaran dari mahasiswa
        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $tahun_ajaran = request('tahun_ajaran', $tahunAjarans->first());

        // Ambil kuota untuk tahun ajaran aktif
        $kuota = \App\Models\Kuota::where('tahun_ajaran', $tahun_ajaran)->first()?->jumlah ?? 0;

        // Ambil data hasil dengan mahasiswa
        $data = Hasil::with('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('tahun_ajaran', $tahun_ajaran))
            ->orderByDesc('qi')
            ->get();

        // Tandai status diterima/tidak
        $data->each(function ($item, $index) use ($kuota) {
            $item->status_diterima = ($index < $kuota) ? 'Diterima' : 'Tidak Diterima';
        });

        // Pagination manual (jika kamu ingin tetap pakai paginate, perlu custom Collection)
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $data->forPage($page, $perPage),
            $data->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.hasil.index', [
            'data' => $paginated,
            'tahunAjarans' => $tahunAjarans,
            'tahun_ajaran' => $tahun_ajaran,
            'status' => $kuota,
        ]);
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
        // Ambil kuota berdasarkan tahun ajaran
        $kuota = Kuota::where('tahun_ajaran', $tahun_ajaran)->first()?->jumlah ?? 0;

        // Ambil data hasil ranking
        $data = Hasil::with(['mahasiswa:id,no_reg,nama,jenis_kelamin,asal_kelas'])
            ->whereHas('mahasiswa', function ($q) use ($tahun_ajaran) {
                $q->where('tahun_ajaran', $tahun_ajaran);
            })
            ->orderBy('qi', 'desc') // pastikan urut dari tertinggi
            ->get();

        // Tambahkan ranking dan status diterima
        $data->each(function ($item, $index) use ($kuota) {
            $item->rank = $index + 1;
            $item->status_diterima = ($index < $kuota) ? 'Diterima' : 'Tidak Diterima';
        });

        return Pdf::loadView('pdf.export', compact('data', 'tahun_ajaran'))
            ->setPaper('a4', 'portrait')
            ->download('hasilPerankingan-' . $tahun_ajaran . '.pdf');
    }
}
