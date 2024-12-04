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
        $data = Mahasiswa::query()->with('hasil', 'nilaiSiswa')->when($request->siswa, function($query, $siswa){
            return $query->where('nama', 'LIKE', '%'.$siswa.'%');
        })->first();
        if(!$data){
            return redirect()->route('home')->with('error', 'Data tidak ditemukan!');
        }
        return view('pages.frontend.siswa.index', compact('data'));
    }

    public function result()
    {
        $hasil = Hasil::count();
        if($hasil == 0){
            return redirect()->back()->with('error', 'data belum tersedia');
        }
        $jurusans = Jurusan::query()->orderBy('priority', 'asc')->get();
        foreach($jurusans as $jurusan){
            $data[$jurusan->id] = Hasil::query()->where('jurusan_id', $jurusan->id)->orderBy('rank', 'asc')->paginate(10);
        }
        return view('pages.frontend.result.index', compact('jurusans', 'data'));
    }
}
