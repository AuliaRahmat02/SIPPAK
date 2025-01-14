@extends('layout.nav')
@section('isi')
<div class="h-12 mt-2 text-right bg-white">
    <a class="tombol bg-info" href="/bezzetting/export">EXPORT EXCEL</a>
    <input type="text"
        id="searchInput"
        class="inline-block w-72 mt-1 mr-40 h-9 px-2 py-1 rounded-lg shadow-xl ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
        placeholder="search..">
</div>
<h1 class="mt-10 font-sans text-2xl font-bold text-center">
    BEZZETTING
</h1>
    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">
            <table class="table">
                <!-- head -->
                <thead class="background-color: #495E57">
                    <tr>
                        <th class="text-black font-bold">No</th>
                        <th class="text-black font-bold">Nama/NIP</th>
                        <th class="text-black font-bold">Golongan</th>
                        <th class="text-black font-bold">Jabatan Sekarang</th>
                        <th class="text-black font-bold">Unit Kerja</th>
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
                            <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} <br> {{ $item->tmt_pns }} </td>
                            <td> {{ $item->jabatan_nm }} </td>
                            <td> {{ $item->opd_nm }} </td>
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

