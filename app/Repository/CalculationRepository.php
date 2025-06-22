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
    public static function calculate($tahun_ajaran)
    {
        $siswas = Mahasiswa::where('tahun_ajaran', $tahun_ajaran)->get();
        foreach ($siswas as $siswa) {
            self::hitungMatriks($siswa, $tahun_ajaran);
        }
    }

    public static function hitungMatriks(Mahasiswa $siswa, $tahun_ajaran)
    {
        $jurusans = Jurusan::all();
        $subKriteria = SubAttribute::all();
        $attributes = Attribute::all();
        $nilaiJurusan = [];

        foreach ($jurusans as $jurusan) {
            $nilai = [];
            foreach ($attributes as $attribute) {
                $val = 0;
                $count = count($attribute->subAttribute->where('jurusan_id', $jurusan->id));
                foreach ($attribute->subAttribute->where('jurusan_id', $jurusan->id) as $sub) {
                    $val += $siswa->nilaiSiswa->where('nilai_id', $sub->nilai_id)->first()?->calculateMatriks($sub->nilai);
                }
                $total = $val / max(1, $count); // hindari div 0
                if ($attribute->tipe === 'cost') {
                    $total = 1 / $total;
                }
                $nilai[$attribute->id] = $total;
            }
            $nilaiJurusan[$jurusan->id] = $nilai;
        }

        self::hitungQi($siswa, $nilaiJurusan, $tahun_ajaran);
    }


    public static function hitungQi(Mahasiswa $siswa, array $matriks, $tahun_ajaran)
    {
        $jurusans = Jurusan::all();
        $attributes = Attribute::all();

        foreach ($jurusans as $jurusan) {
            $perkalian = [];
            $pow = [];

            foreach ($attributes as $attribute) {
                $perkalian[] = $matriks[$jurusan->id][$attribute->id] * $attribute->bobot;
                $pow[] = pow($matriks[$jurusan->id][$attribute->id], $attribute->bobot);
            }

            $totalPerkalian = array_sum($perkalian) * 0.5;
            $totalPow = array_reduce($pow, fn($carry, $item) => $carry === 0 ? $item : $carry * $item, 0);
            $totalPow = $totalPow * 0.5;

            $hasilQi = $totalPerkalian + $totalPow;

            Hasil::updateOrCreate(
                [
                    'mahasiswa_id' => $siswa->id,
                    'jurusan_id' => $jurusan->id,
                    'tahun_ajaran' => $tahun_ajaran,
                ],
                [
                    'qi' => $hasilQi,
                ]
            );
        }
    }

    public static function pengelompokan($tahun_ajaran)
    {
        $jurusans = Jurusan::orderBy('priority', 'asc')->get();

        foreach ($jurusans as $jurusan) {
            $hasilQi = Hasil::where('jurusan_id', $jurusan->id)
                ->where('tahun_ajaran', $tahun_ajaran)
                ->orderByDesc('qi')
                ->get();

            $rank = 1;
            foreach ($hasilQi as $hasil) {
                $hasil->rank = $rank++;
                $hasil->save();
            }
        }
    }
}
