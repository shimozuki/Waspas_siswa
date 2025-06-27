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
        $normalisasi = [];

        foreach ($mahasiswas as $siswa) {
            self::hitungMatriks($siswa, $tahun_ajaran);

            // 🔧 Simpan hasil jika hitungMatriks menyimpan nilai ke session
            $normalisasi[$siswa->id] = session("normalisasi_matriks.{$siswa->id}", []);
        }

        session(['normalisasi_matriks' => $normalisasi]);
    }


    public static function hitungMatriks(Mahasiswa $siswa, $tahun_ajaran)
    {
        $jurusans = Jurusan::all();
        $attributes = Attribute::all();
        $nilaiJurusan = [];

        // Ambil nilai maksimum dari semua siswa per jurusan & atribut
        $maxAll = self::getMaxPerAttribute($tahun_ajaran);

        foreach ($jurusans as $jurusan) {
            $nilai = [];

            foreach ($attributes as $attribute) {
                $nilaiMentah = [];

                // Loop semua sub-atribut dari jurusan dan attribute ini
                foreach ($attribute->subAttribute->where('jurusan_id', $jurusan->id) as $sub) {
                    $nilaiModel = $siswa->nilaiSiswa->where('nilai_id', $sub->nilai_id)->first();
                    if ($nilaiModel) {
                        $nilaiMentah[] = $nilaiModel->poin;
                    }
                    \Log::info("Total untuk atribut {$attribute->nama} = " . array_sum($nilaiMentah) . " dari " . count($nilaiMentah));
                }

                // Rata-rata nilai mentah siswa untuk attribute ini
                $total = count($nilaiMentah) > 0 ? array_sum($nilaiMentah) / count($nilaiMentah) : 0;

                // Ambil nilai max untuk jurusan & attribute ini
                $maxValue = $maxAll[$jurusan->id][$attribute->id] ?? 1;

                // Hindari pembagian nol
                $normalized = $maxValue > 0 ? $total / $maxValue : 0;

                // Jika cost, maka invers
                if ($attribute->tipe === 'cost') {
                    $normalized = $normalized > 0 ? 1 / $normalized : 0;
                }

                // Simpan nilai normalisasi
                $nilai[$attribute->id] = $normalized;
            }

            // Simpan per jurusan
            $nilaiJurusan[$jurusan->id] = $nilai;
        }

        session()->put("normalisasi_matriks.{$siswa->id}", $nilaiJurusan);
        // Lanjutkan ke hitung Qi
        self::hitungQi($siswa, $nilaiJurusan, $tahun_ajaran);
    }
    private static function getMaxPerAttribute($tahun_ajaran)
    {
        $max = [];
        $attributes = Attribute::all();
        $jurusans = Jurusan::all();
        $siswas = Mahasiswa::where('tahun_ajaran', $tahun_ajaran)->get();

        foreach ($jurusans as $jurusan) {
            foreach ($attributes as $attribute) {
                $nilaiSemua = [];

                foreach ($siswas as $siswa) {
                    $nilaiMentah = [];

                    foreach ($attribute->subAttribute->where('jurusan_id', $jurusan->id) as $sub) {
                        $nilaiModel = $siswa->nilaiSiswa->where('nilai_id', $sub->nilai_id)->first();
                        if ($nilaiModel) {
                            $nilaiMentah[] = $nilaiModel->poin;
                        }
                    }

                    if (count($nilaiMentah) > 0) {
                        $total = array_sum($nilaiMentah) / count($nilaiMentah);
                        $nilaiSemua[] = $total;
                    }
                }

                $max[$jurusan->id][$attribute->id] = count($nilaiSemua) > 0 ? max($nilaiSemua) : 1;
            }
        }

        return $max;
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
