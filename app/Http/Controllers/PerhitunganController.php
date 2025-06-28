<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Hasil;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\SubAttribute;
use App\Repository\CalculationRepository;
use App\Repository\WaspasRepository;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        $checkHasil = Hasil::count();
        $data['attributes'] = Attribute::all();
        $data['sub'] = SubAttribute::all(); // tetap diambil, tapi tidak filter jurusan
        // $data['jurusan'] = Jurusan::all(); // HAPUS bagian ini karena sudah tidak dipakai

        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');
        $tahun_ajaran = request('tahun_ajaran', null);
        $hasHasil = Hasil::where('tahun_ajaran', $tahun_ajaran)->exists();

        $data['tahunAjarans'] = $tahunAjarans;
        $data['mahasiswas'] = Mahasiswa::where('tahun_ajaran', $tahun_ajaran)->paginate(10);

        // 🔧 Jalankan perhitungan normalisasi + Qi
        \App\Repository\CalculationRepository::calculate($tahun_ajaran);

        // 🔧 Ambil hasil normalisasi dari session
        $normalisasi = session('normalisasi_matriks', []);
        $qiValues = session('qi_values', []);

        return view('pages.perhitungan.index', compact(
            'data',
            'checkHasil',
            'tahun_ajaran',
            'tahunAjarans',
            'hasHasil',
            'normalisasi',
            'qiValues'
        ));
    }

    public function save(Request $request)
    {
        $tahun_ajaran = $request->input('tahun_ajaran');

        $qiValues = session('qi_values', []);
        if (empty($qiValues)) {
            return back()->with('error', 'Belum ada perhitungan Qi!');
        }

        foreach ($qiValues as $mahasiswa_id => $qi) {
            Hasil::updateOrCreate(
                ['mahasiswa_id' => $mahasiswa_id, 'tahun_ajaran' => $tahun_ajaran],
                ['qi' => $qi, 'rank' => 0]
            );
        }
        CalculationRepository::generateRanking($tahun_ajaran);

        return redirect()->route('hasil.index', ['tahun_ajaran' => $tahun_ajaran])
            ->with('success', 'Hasil Qi berhasil disimpan ke database.');
    }
}
