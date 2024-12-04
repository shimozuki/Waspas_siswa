<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    @auth
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <a href="{{ route('hasil.export') }}" class="btn bg-red-500 hover:bg-red-600 text-white">
                <i class="fa-solid fa-file-pdf"></i>
                <span class="hidden xs:block ml-2">Export PDF</span>
            </a>
        </div>
    @endauth
    <div class="relative overflow-x-auto">
        @auth
            <div class="bg-white rounded-t-lg p-4">
                <h5 class="mr-3 font-semibold dark:text-white">Hasil Perankingan {{ $jurusan->nama }}</h5>
            </div>
        @endauth
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Ranking
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No Reg
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Kelamin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Asal Kelas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nilai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $data->firstItem() + $loop->index }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $row->mahasiswa->no_reg }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->mahasiswa->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->mahasiswa->jenis_kelamin }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->mahasiswa->asal_kelas }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->rank }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-2">
            {{ $data->links() }}
        </div>
    </div>

</div>
