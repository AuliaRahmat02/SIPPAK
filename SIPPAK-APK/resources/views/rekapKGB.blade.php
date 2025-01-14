@extends('layout.nav')
@section('isi')
<div class="h-12 mt-2 text-right bg-white">
    <a href="/rekapKGBExport" class="tombol">Export</a>
    <input type="text" id="searchInput"
        class="inline-block px-2 py-1 mt-1 mr-40 rounded-lg shadow-xl w-72 h-9 ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
        placeholder="search..">
</div>
<h1 class="mt-10 font-sans text-2xl font-bold text-center">
    DAFTAR REKAPITULASI KENAIKAN GAJI BERKALA(KGB)
</h1>
    <div class="mx-auto mt-10 w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="font-bold text-black">No</th>
                        <th class="font-bold text-black">Nama/NIP</th>
                        <th class="font-bold text-black">Golongan</th>
                        <th class="font-bold text-black">TMT Gaji</th>
                        <th class="font-bold text-black">Unit Kerja</th>
                        <th class="font-bold text-black">Aksi</th>

                    </tr>
                </thead>
                <tbody id="tableBody">
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($buku as $item)
                        <tr class="hover">
                            <th> {{ $count }} </th>
                            <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                            <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} </td>
                            <td> {{ $item->tmt_gaji_N }} </td>
                            <td> {{ $item->opd_nm }} </td>
                            <td>
                                <a href="/printKGB/{{ $item->nip }}" class="bg-green-600 tombol">Print</a>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    <!-- row 1 -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('fungsi')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var searchText = this.value.toLowerCase();
            var tableRows = document.getElementById('tableBody').getElementsByTagName('tr');

            for (var i = 0; i < tableRows.length; i++) {
                var rowText = tableRows[i].textContent.toLowerCase();
                if (rowText.includes(searchText)) {
                    tableRows[i].style.display = '';
                } else {
                    tableRows[i].style.display = 'none';
                }
            }
        });
    </script>
@endsection
