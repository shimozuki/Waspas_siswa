<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\HasilQi;
use App\Models\Jurusan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HasilController extends Controller
{
    function index()
    {
        $jurusans = Jurusan::query()->orderBy('priority', 'asc')->get();
        foreach($jurusans as $jurusan){
            $data[$jurusan->id] = Hasil::query()->where('jurusan_id', $jurusan->id)->paginate(10);
        }
        return view('pages.hasil.index', compact('jurusans', 'data'));    
    }

    function export(Request $request)
    {
        $jurusan = Jurusan::findOrFail($request->jurusan);
        $data = Hasil::query()->where('jurusan_id', $request->jurusan)->orderBy('rank', 'asc')->get();
        $pdf = Pdf::loadView('pdf.export', ['data' => $data, 'jurusan' => $jurusan]);
        return $pdf->download('hasilPerankingan-' . $jurusan->nama . '.pdf');
    }
}
