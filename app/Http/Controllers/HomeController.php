<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'male' => Mahasiswa::query()->where('jenis_kelamin', 'LAKI-LAKI')->count(),
            'female' => Mahasiswa::query()->where('jenis_kelamin', 'PEREMPUAN')->count(),
            'total' => Mahasiswa::count(), 
            'jurusan' => Jurusan::query()->get(),
            'hasil' => Hasil::count(),
        ];
        return view('welcome' ,compact('data'));
    }
}
