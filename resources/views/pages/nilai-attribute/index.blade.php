<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        @foreach ($attributes as $attribute)
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap justify-between">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">({{$attribute->kode}}) {{$attribute->nama}}</h2>
                    </header>
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <a href="{{route('nilai-attribute.create', $attribute->id)}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden xs:block ml-2">Tambah Nilai</span>
                        </a>
                    </div>
                </div>
                <div class="p-3">
                <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="tableIndex" class="table-auto w-full dark:text-slate-300">
                            <!-- Table header -->
                            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Value Attribute</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Nilai Attribute</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                                <!-- Row -->
                                @foreach ($attribute->getAllNilaiAttribute() as $nilai)      
                                <tr>
                                    <td class="p-2">
                                        <div class="text-center">{{$nilai->value}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">{{$nilai->nilai}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center text-emerald-500">
                                            <a href="{{route("nilai-attribute.edit", $nilai->id)}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white mr-2">
                                                <i class="fa-solid fa-edit"></i></a><button onclick="showModals({{$nilai->id}})" class="btn bg-red-600 hover:bg-red-700 text-white">
                                                <i class="fa-solid fa-trash"></i></button>
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
        @endforeach
    </div>
    @push('custom-scripts')
    <script type="text/javascript">
        function showModals(id){
            Swal.fire({
                title: "Yakin ingin Menghapus Nilai Attribute Ini ?",
                text: "Data Akan Terhapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type:'POST',
                    url: "{{route('nilai-attribute.delete')}}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id:id,
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