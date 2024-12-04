<x-guest-layout>
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="mb-4">
            <h1 class="font-semibold text-center text-2xl">Informasi Siswa</h1>
        </div>
        <div class="w-full border border-gray-100 p-4 mb-4 shadow-sm">
            <p class="text-gray-700">NAMA : <span class="font-semibold">{{ $data->nama }}</span></p>
            <p class="text-gray-700">JENIS KELAMIN : <span class="font-semibold">{{ $data->jenis_kelamin }}</span></p>
            <p class="text-gray-700">KELAS : <span class="font-semibold">{{ $data->asal_kelas }}</span></p>
            @if ($data->hasil)
                <p class="text-gray-700">PENJURUSAN : <span
                        class="font-semibold">{{ $data->hasil->jurusan->nama }}</span>
                </p>
            @endif
        </div>
        <div class="w-full border border-gray-100 shadow-sm">
            <div class="p-2">
                <h2 class="font-semibold">Data Nilai Siswa</h2>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Mata Pelajaran
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nilai
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->nilaiSiswa as $row)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $row->nilai->nama }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $row->poin }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-guest-layout>
