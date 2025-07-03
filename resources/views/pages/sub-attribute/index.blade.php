<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <a href="{{ route('sub-attribute.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden xs:block ml-2">Tambah Sub Kriteria</span>
            </a>
        </div>
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div
                class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Sub Kriteria</h2>
                </header>
                <div class="p-3">

                    <!-- Table -->
                    <table id="tableIndex" class="w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">No</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Kriteria</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Kurang</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Cukup</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Baik</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Sangat Baik</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Aksi</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                            @php $no = 1; @endphp
                            @foreach ($grouped as $kriteria => $subitems)
                            <tr>
                                <!-- Kolom NO -->
                                <td class="px-4 py-2 font-semibold">{{ $no++ }}</td>

                                <!-- Kolom Kriteria -->
                                <td class="px-4 py-2 font-semibold">{{ $kriteria }}</td>

                                <!-- Kolom Rentang per Kategori -->
                                @php
                                $kategori = ['Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
                                @endphp
                                @foreach ($kategori as $nama)
                                @php
                                $item = $subitems->firstWhere('nilai.nama', $nama);
                                @endphp
                                <td class="py-2">
                                    @if ($item)
                                    <div class="text-left">{{ number_format($item->nilai_min, 2) }} - {{ number_format($item->nilai_max, 2) }}</div>
                                    @else
                                    -
                                    @endif
                                </td>
                                @endforeach

                                <!-- Kolom Aksi -->
                                <td class="px-4 py-2">
                                    <button onclick="openDeleteSelect({{ $loop->index }})"
                                        class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded">
                                        Hapus
                                    </button>

                                    <!-- Modal Select -->
                                    <div id="modal-select-{{ $loop->index }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                            <h2 class="text-lg font-semibold mb-4">Pilih Sub Kategori yang Ingin Dihapus</h2>

                                            <select id="select-sub-id-{{ $loop->index }}"
                                                class="w-full border px-3 py-2 rounded mb-4">
                                                <option value="" disabled selected>Pilih Sub Kategori</option>
                                                @php $kategori = ['Kurang', 'Cukup', 'Baik', 'Sangat Baik']; @endphp
                                                @foreach ($kategori as $nama)
                                                @php $item = $subitems->firstWhere('nilai.nama', $nama); @endphp
                                                @if ($item)
                                                <option value="{{ $item->id }}">
                                                    {{ $nama }} ({{ number_format($item->nilai_min, 2) }} - {{ number_format($item->nilai_max, 2) }})
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>

                                            <div class="flex justify-end gap-2">
                                                <button onclick="closeDeleteSelect({{ $loop->index }})"
                                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded">Batal</button>
                                                <button onclick="confirmDeleteSelected({{ $loop->index }})"
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
    @push('custom-scripts')
    <script>
        function openDeleteSelect(index) {
            document.getElementById(`modal-select-${index}`).classList.remove('hidden');
        }

        function closeDeleteSelect(index) {
            document.getElementById(`modal-select-${index}`).classList.add('hidden');
        }

        function confirmDeleteSelected(index) {
            const select = document.getElementById(`select-sub-id-${index}`);
            const id = select.value;

            if (!id) {
                Swal.fire("Pilih kategori terlebih dahulu", "", "warning");
                return;
            }

            Swal.fire({
                title: "Yakin ingin menghapus sub kriteria ini?",
                text: "Data akan terhapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#aaa",
                confirmButtonText: "Ya, Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('sub-attribute.delete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                        },
                        success: () => {
                            Swal.fire("Dihapus!", "Data berhasil dihapus.", "success")
                                .then(() => location.reload());
                        }
                    });
                }
            });
        }
    </script>


    <script type="text/javascript">
        function showModals(id) {
            Swal.fire({
                title: "Yakin ingin Menghapus Data Sub Kriteria Ini ?",
                text: "Data Akan Terhapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('sub-attribute.delete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                        }
                    })
                    Swal.fire(
                        'Dihapus!',
                        'Data Sub Kriteria berhasil dihapus !',
                        'success',
                    ).then((after) => location.reload())
                }
            });
        }
    </script>
    <style>
        .dataTables_length select {
            width: 100px;
            padding: 5px;
            font-size: 14px;
        }
    </style>
    @endpush
</x-app-layout>