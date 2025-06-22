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
    function index()
    {
        $checkHasil = Hasil::count();
        $data['attributes'] = Attribute::all();
        $data['sub'] = SubAttribute::all();
        $data['jurusan'] = Jurusan::all();

        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');
        $tahun_ajaran = request('tahun_ajaran', now()->year);
        $hasHasil = Hasil::where('tahun_ajaran', $tahun_ajaran)->exists();

        $data['tahunAjarans'] = $tahunAjarans;
        $data['mahasiswas'] = Mahasiswa::where('tahun_ajaran', $tahun_ajaran)->paginate(10);

        return view('pages.perhitungan.index', compact('data', 'checkHasil', 'tahun_ajaran', 'tahunAjarans', 'hasHasil'));
    }


    function save(Request $request)
    {
        $tahun_ajaran = $request->input('tahun_ajaran');
        if (!$tahun_ajaran) {
            return redirect()->back()->with('error', 'Tahun ajaran belum dipilih!');
        }

        $jurusan = Jurusan::count();
        if ($jurusan == 0) {
            return redirect()->back()->with('error', 'Harap isi Jurusan!');
        }

        $mahasiswas = Mahasiswa::where('tahun_ajaran', $tahun_ajaran)->get();
        if ($mahasiswas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada mahasiswa untuk tahun ajaran ini!');
        }

        CalculationRepository::calculate($tahun_ajaran);
        CalculationRepository::pengelompokan($tahun_ajaran);

        return redirect()->route('hasil.index', ['tahun_ajaran' => $tahun_ajaran])
            ->with('success', 'Hasil perangkingan disimpan!');
    }
}
