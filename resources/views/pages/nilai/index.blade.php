<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <a href="{{ route('nilai.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden xs:block ml-2">Nilai</span>
            </a>
        </div>
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div
                class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Nilai</h2>
                </header>
                <div class="p-3">

                    <!-- Table -->
                    <table id="tableIndex" class="w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Nama</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Created</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Updated</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Aksi</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            $(document).ready(function() {
                $('#tableIndex').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ url()->current() }}',
                    columns: [{
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'edit',
                            name: 'edit'
                        },
                    ]
                });
            });
        </script>
        <script type="text/javascript">
            function showModals(id) {
                Swal.fire({
                    title: "Yakin ingin Menghapus Data Nilai Ini ?",
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
                            url: "{{ route('nilai.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            }
                        })
                        Swal.fire(
                            'Dihapus!',
                            'Data Nilai berhasil dihapus !',
                            'success',
                        ).then((after) => location.reload())
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
