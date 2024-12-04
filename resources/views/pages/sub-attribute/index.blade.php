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
                                    <div class="font-semibold text-left">Jurusan</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Kriteria</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Nilai</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Aksi</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach ($data as $row)
                                <tr>
                                    <td class="p-2">
                                        <div class="font-semibold text-left">{{ $row->jurusan->nama }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="font-semibold text-left">{{ $row->attribute->nama }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="font-semibold text-left">{{ $row->nilai->nama }}</div>
                                    </td>
                                    <td class="p-2">
                                        <button onclick="showModals({{ $row->id }})"
                                            class="btn bg-red-600 hover:bg-red-700 text-white">
                                            <i class="fa-solid fa-trash"></i></button>
                                    </td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $data->links() }}
    </div>
    @push('custom-scripts')
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
    @endpush
</x-app-layout>
