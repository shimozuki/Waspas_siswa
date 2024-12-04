<?php

namespace App\Repository;

use App\Models\Attribute;
use App\Models\Hasil;
use App\Models\HasilQi;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\SubAttribute;

class CalculationRepository
{
    public static function calculate()
    {
        $siswas = Mahasiswa::query()->get();
        foreach($siswas as $siswa){
            CalculationRepository::hitungMatriks($siswa);
        }
    }

    public static function hitungMatriks(Mahasiswa $siswa)
    {
        $jurusans = Jurusan::query()->get();
        $subKriteria = SubAttribute::query()->get();
        $attributes = Attribute::query()->get();
        $nilaiJurusan = [];
        foreach($jurusans as $jurusan){
            $nilai = [];
            foreach($attributes as $attribute){
                $val = 0;
                $count = count($attribute->subAttribute->where('jurusan_id', $jurusan->id));
                foreach($attribute->subAttribute->where('jurusan_id', $jurusan->id) as $sub){
                    $val = $val +  $siswa->nilaiSiswa->where('nilai_id', $sub->nilai_id)->first()?->calculateMatriks($sub->nilai);
                }
                $total = $val/$count;
                $nilai[$attribute->id] = $total;
            }
            $nilaiJurusan[$jurusan->id] = $nilai;
        }
        CalculationRepository::hitungQi($siswa, $nilaiJurusan);
    }

    public static function hitungQi(Mahasiswa $siswa, array $matriks)
    {
        $jurusans = Jurusan::query()->get();
        $attributes = Attribute::query()->get();
        foreach($jurusans as $jurusan){
            $perkalian = [];
            $pow = [];
            foreach($attributes as $attribute){
                $perkalian[] = $matriks[$jurusan->id][$attribute->id] * $attribute->bobot;
                $pow[] = pow($matriks[$jurusan->id][$attribute->id], $attribute->bobot);
            }
            $totalPerkalian = array_sum($perkalian) * 0.5;
            $totalPow = 0;
            foreach($pow as $p){
                if($totalPow != 0){
                    $totalPow = $totalPow * $p;
                }else{
                    $totalPow = $p;
                }
            }
            $totalPow = $totalPow * 0.5;
            $hasilQi = $totalPerkalian+$totalPow;
            HasilQi::create([
                'mahasiswa_id' => $siswa->id,
                'jurusan_id' => $jurusan->id,
                'qi' => $hasilQi,
            ]);
        }
    }

    public static function pengelompokan()
    {
        $jurusans = Jurusan::query()->orderBy('priority', 'asc')->get();
        $ranks = 0;
        foreach($jurusans as $jurusan){
            $hasilQi = HasilQi::query()->where('jurusan_id', $jurusan->id)->orderBy('qi', 'desc')->get();
            foreach($hasilQi as $hasilq){
                if($ranks < $jurusan->quota){
                    if(!$hasilq->mahasiswa->hasil){
                        $ranks++;
                        Hasil::create([
                            'mahasiswa_id' => $hasilq->mahasiswa_id,
                            'jurusan_id' => $jurusan->id,
                            'rank' => $ranks,
                        ]);
                    }
                }
            }
            $ranks = 0;
        }
    }
}