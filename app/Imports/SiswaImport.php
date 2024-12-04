<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Nilai;
use App\Models\NilaiSiswa;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        try{
            $nilai = Nilai::query()->get();
            foreach($collection as $row){
                if($row['nama'] != null){
                    $siswa = Mahasiswa::create([
                        'no_reg' => $row['no_reg'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'asal_kelas' => $row['asal_kelas'],
                    ]);
                    foreach($nilai as $kriteria){
                        if($row[preg_replace('/\s+/', '_', strtolower($kriteria->nama))] != null){
                            NilaiSiswa::create([
                                'mahasiswa_id' => $siswa->id,
                                'nilai_id' => $kriteria->id,
                                'poin' => $row[strtolower(preg_replace('/\s+/', '_', strtolower($kriteria->nama)))],
                            ]);
                        }
                    }
                }
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
