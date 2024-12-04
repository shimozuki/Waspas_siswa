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
        $data['attributes'] = Attribute::query()->get();
        $data['sub'] = SubAttribute::query()->get();
        $data['mahasiswas'] = Mahasiswa::paginate(10);
        $data['jurusan'] = Jurusan::query()->get();
        return view('pages.perhitungan.index', compact('data', 'checkHasil'));
    }

    function save()
    {
        $jurusan = Jurusan::count();
        if($jurusan == 0){
            return redirect()->back()->with('error', 'Harap isi Jurusan!');
        }
        $mahasiswas = Mahasiswa::query()->get();
        CalculationRepository::calculate();
        CalculationRepository::pengelompokan();
        return redirect()->route('hasil.index')->with('success', 'Hasil perangkingan disimpan!');
    }
}
