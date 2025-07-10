<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Repository\WaspasRepository;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function siswa(Request $request)
    {
        $data = Mahasiswa::query()->with('hasil', 'nilaiSiswa')->when($request->siswa, function ($query, $siswa) {
            return $query->where('nama', 'LIKE', '%' . $siswa . '%');
        })->first();
        if (!$data) {
            return redirect()->route('home')->with('error', 'Data tidak ditemukan!');
        }
        return view('pages.frontend.siswa.index', compact('data'));
    }

    public function result(Request $request)
    {
        $hasil = Hasil::count();
        if ($hasil == 0) {
            return redirect()->back()->with('error', 'Data belum tersedia');
        }

        $tahunAjarans = Mahasiswa::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $tahun_ajaran = request('tahun_ajaran', $tahunAjarans->first());

        $data = Hasil::with('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('tahun_ajaran', $tahun_ajaran))
            ->orderByDesc('qi')
            ->paginate(10);

        $status = Hasil::whereHas('mahasiswa', fn($q) => $q->where('tahun_ajaran', $tahun_ajaran))
            ->first()?->status ?? 0;

        return view('pages.frontend.result.index', compact('data', 'tahunAjarans', 'tahun_ajaran', 'status'));
    }
}
