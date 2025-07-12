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
        $mahasiswas = Mahasiswa::with('nilaiSiswa')->where('tahun_ajaran', $tahun_ajaran)->get();
        $attributes = Attribute::all();

        $maxAll = self::getMaxPerAttribute($tahun_ajaran);
        $minAll = self::getMinPerAttribute($tahun_ajaran);

        $qiValues = [];

        foreach ($mahasiswas as $siswa) {
            $nilai = [];

            foreach ($attributes as $attribute) {
                // Ambil semua nilai_id dari attribute ini
                $nilaiIds = \App\Models\Nilai::where('attribute_id', $attribute->id)->pluck('id')->toArray();

                // Ambil poin siswa dari nilai_id yang sesuai
                $nilaiMentah = $siswa->nilaiSiswa->firstWhere(fn($n) => in_array($n->nilai_id, $nilaiIds))?->poin ?? 0;

                if ($attribute->tipe === 'cost') {
                    $min = $minAll[$attribute->id] ?? 1;
                    $nilai[$attribute->id] = $nilaiMentah > 0 ? $min / $nilaiMentah : 0;
                } else {
                    $max = $maxAll[$attribute->id] ?? 1;
                    $nilai[$attribute->id] = $max > 0 ? $nilaiMentah / $max : 0;
                }
            }


            session()->put("normalisasi_matriks.{$siswa->id}", $nilai);

            // 🔴 Hitung nilai Qi
            $nilaiQi = self::hitungQiSementara($siswa, $nilai);
            $qiValues[$siswa->id] = round($nilaiQi, 4);
        }

        session()->put('qi_values', $qiValues); // ⬅️ SIMPAN hasil QI untuk blade
    }


    public static function hitungMatriks(Mahasiswa $siswa, $tahun_ajaran)
    {
        $attributes = Attribute::all();
        $nilai = [];

        $maxAll = self::getMaxPerAttribute($tahun_ajaran);
        $minAll = self::getMinPerAttribute($tahun_ajaran);

        foreach ($attributes as $attribute) {
            // ✅ Ambil semua poin sub-kriteria dan jumlahkan
            $nilaiMentah = $siswa->nilaiSiswa
                ->whereIn('nilai_id', $attribute->subAttribute->pluck('nilai_id'))
                ->sum('poin');

            $normalized = 0;

            if ($attribute->tipe === 'cost') {
                $minValue = $minAll[$attribute->id] ?? 1;
                $normalized = $nilaiMentah > 0 ? $minValue / $nilaiMentah : 0;
            } else {
                $maxValue = $maxAll[$attribute->id] ?? 1;
                $normalized = $maxValue > 0 ? $nilaiMentah / $maxValue : 0;
            }

            $nilai[$attribute->id] = round($normalized, 4); // bulatkan 4 digit
        }

        session()->put("normalisasi_matriks.{$siswa->id}", $nilai);
        self::hitungQi($siswa, $nilai, $tahun_ajaran);
    }

    private static function getMaxPerAttribute($tahun_ajaran)
    {
        $max = [];
        $attributes = Attribute::all();
        $siswas = Mahasiswa::with('nilaiSiswa')->where('tahun_ajaran', $tahun_ajaran)->get();

        foreach ($attributes as $attribute) {
            $nilaiIds = \App\Models\Nilai::where('attribute_id', $attribute->id)->pluck('id')->toArray();
            $nilaiSemua = [];

            foreach ($siswas as $siswa) {
                $nilaiMentah = $siswa->nilaiSiswa
                    ->firstWhere(fn($n) => in_array($n->nilai_id, $nilaiIds))
                    ?->poin ?? 0;

                if ($nilaiMentah > 0) {
                    $nilaiSemua[] = $nilaiMentah;
                }
            }

            $max[$attribute->id] = count($nilaiSemua) > 0 ? max($nilaiSemua) : 1;
        }

        return $max;
    }



    private static function getMinPerAttribute($tahun_ajaran)
    {
        $min = [];
        $attributes = Attribute::all();
        $siswas = Mahasiswa::with('nilaiSiswa')->where('tahun_ajaran', $tahun_ajaran)->get();

        foreach ($attributes as $attribute) {
            $nilaiIds = \App\Models\Nilai::where('attribute_id', $attribute->id)->pluck('id')->toArray();
            $nilaiSemua = [];

            foreach ($siswas as $siswa) {
                $nilaiMentah = $siswa->nilaiSiswa
                    ->firstWhere(fn($n) => in_array($n->nilai_id, $nilaiIds))
                    ?->poin ?? 0;

                if ($nilaiMentah > 0) {
                    $nilaiSemua[] = $nilaiMentah;
                }
            }

            $min[$attribute->id] = count($nilaiSemua) > 0 ? min($nilaiSemua) : 1;
        }

        return $min;
    }


    public static function hitungQiSementara(Mahasiswa $siswa, array $matriks)
    {
        $attributes = Attribute::all();
        $perkalian = [];
        $pangkat = [];

        foreach ($attributes as $attribute) {
            $normalized = $matriks[$attribute->id] ?? 0;
            $perkalian[] = $normalized * $attribute->bobot;
            $pangkat[] = pow($normalized, $attribute->bobot);
        }

        $totalPerkalian = array_sum($perkalian) * 0.5;
        $totalPangkat = array_product($pangkat) * 0.5;

        return $totalPerkalian + $totalPangkat;
    }

    public static function hitungQi(Mahasiswa $siswa, array $matriks, $tahun_ajaran)
    {
        $attributes = Attribute::all();
        $perkalian = [];
        $pow = [];

        foreach ($attributes as $attribute) {
            $normalized = $matriks[$attribute->id] ?? 0;
            $perkalian[] = $normalized * $attribute->bobot;
            $pow[] = pow($normalized, $attribute->bobot);
        }

        $totalPerkalian = array_sum($perkalian) * 0.5;
        $totalPow = array_product($pow) * 0.5;
        $hasilQi = $totalPerkalian + $totalPow;

        Hasil::updateOrCreate(
            [
                'mahasiswa_id' => $siswa->id,
                'tahun_ajaran' => $tahun_ajaran,
            ],
            [
                'qi' => $hasilQi,
                'rank' => 0, // <--- tambahkan ini
            ]
        );
    }
    public static function generateRanking($tahun_ajaran)
    {
        // Ambil semua hasil Qi untuk tahun ajaran tertentu, urutkan dari terbesar ke terkecil
        $hasilSemua = Hasil::whereHas('mahasiswa', function ($query) use ($tahun_ajaran) {
            $query->where('tahun_ajaran', $tahun_ajaran);
        })->orderByDesc('qi')->get();

        $ranking = 1;
        foreach ($hasilSemua as $hasil) {
            $hasil->rank = $ranking++;
            $hasil->save();
        }
    }

    public static function pengelompokan($tahun_ajaran)
    {
        $hasilQi = Hasil::where('tahun_ajaran', $tahun_ajaran)
            ->orderByDesc('qi')
            ->get();

        $rank = 1;
        foreach ($hasilQi as $hasil) {
            $hasil->rank = $rank++;
            $hasil->save();
        }
    }
}
