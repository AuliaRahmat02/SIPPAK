@extends('layout.nav')
@section('isi')
    <div class="h-12 mt-2 text-right bg-white">
        <a class="tombol bg-success" href="/SuratPensiun">Surat</a>
        <input type="text"
            id="searchInput"
            class="inline-block w-72 mt-1 mr-40 h-9 px-2 py-1 rounded-lg shadow-xl ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
            placeholder="search..">
    </div>

    <h1 class="mt-10 font-sans text-2xl font-bold text-center">
        SURAT PENGANTAR PENGURUSAN PENSIUN
    </h1>
    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">
        @can('operator')
            <form action="/P_Pensiun_op" method="POST">
                @csrf
                    <div>
                        <label class="font-bold" for="">Nomor Surat :</label>
                        <input name="nomor_surat" type="text" placeholder="Nomor Surat" value="{{ old('nomor_surat') }}" class="input input-bordered input-success w-full max-w-xs"><br>
                        @error('nomor_surat')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="my-5">
                        <label class="font-bold" for="">Nama Surat :</label>
                        <input name="nama" type="text" placeholder="Nama Surat" value="{{ old('nama') }}" class="input input-bordered input-success w-full max-w-xs"><br>
                        @error('nama')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="my-5">
                        <label class="font-bold" for="">Periode :</label><span class="font-bold"> {{ $periode }}</span>
                    </div>
                <table class="table table-zebra">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="font-bold text-black">No</th>
                            <th class="font-bold text-black">Nama/NIP</th>
                            <th class="font-bold text-black">golru</th>
                            <th class="font-bold text-black">Pangkat/Gol</th>
                            <th class="font-bold text-black">Biro</th>
                            <th class="font-bold text-black">Pengajuan surat</th>
                            <th class="font-bold text-black">Profil</th>
                            <th class="font-bold text-black">Hapus</th>

                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        <?php $count = 1; ?>
                            @foreach ($buku as $item)
                                <tr class="hover">
                                    <th> {{ $count }} </th>
                                    <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                                    <td>{{ $item->tmt_golru_N }}</td>
                                    <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} <br> {{ $item->tmt_pns }} </td>
                                    <td> {{ $item->opd_nm }} </td>
                                    <td class="text-center"><input class="checkbox checkbox-success" type="checkbox" checked="checked" name="nip[]" value="{{ $item->nip }}"></td>
                                    <td><a class="tombol bg-info" href="/dashboard/datapegawai/{{ $item->nip }}">Profil</a></td>
                                    <td><a class="tombol bg-red-600" href="/HapusPensiun/{{ $item->nip }}">Hapus</a></td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                    </tbody>
                </table>
                <button class="tombol bg-success" type="submit">Ajukan</button>
            </form>
            @endcan
            @if (Auth::user()->can('jft')||Auth::user()->can('kabag')||Auth::user()->can('kabiro'))
                <form action="/P_naik_op" method="POST">
                    @csrf
                    <table class="table table-zebra">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th class="font-bold text-black">No</th>
                                <th class="font-bold text-black">Nama Surat</th>
                                <th class="font-bold text-black">Nomor Surat</th>
                                <th class="font-bold text-black">Lihat surat</th>
                                <th class="font-bold text-black">Verifikasi</th>
                                <th class="font-bold text-black">Tolak</th>

                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            <?php $count = 1; ?>
                                @foreach ($surat as $item)
                                    <tr class="hover">
                                        <th> {{ $count }} </th>
                                        <td>{{ $item->nama_surat}}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td><a class="tombol bg-info" href="/preview_surat/{{ $item->ID }}">Lihat surat</a></td>
                                        <td><a class="tombol bg-success" href="/verifikasi_pensiun/{{ $item->ID }}">Verifikasi</a></td>
                                        <td><a class="tombol bg-error" href="/tolak_show/{{ $item->ID }}">Tolak</a></td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @endforeach
                        </tbody>
                    </table>
            @endif
        </div>
    </div>
@can('operator')
    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">
            <h1>SURAT YANG DI AJUKAN</h1>
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="font-bold text-black">No</th>
                        <th class="font-bold text-black">Nomor Surat</th>
                        <th class="font-bold text-black">Nama Surat</th>
                        <th class="font-bold text-black">Verifikasi</th>
                        <th class="font-bold text-black">pesan</th>
                        <th class="font-bold text-black">Hapus</th>
                        </tr>
                </thead>

                <tbody id="tableBody">
                    <?php $count = 1; ?>
                    @foreach ($surat as $s)
                        <tr class="hover">
                            <th> {{ $count }} </th>
                            <td>{{ $s->nomor_surat }}</td>
                            <td>{{ $s->nama_surat }}</td>
                            @if (($s->tolak != null)&&($s->fase==1))
                                <td>
                                    <a class="tombol bg-success" href="/verifikasi_pensiun/{{ $s->ID }}">Ajukan Lagi</a><br>
                                    <a class="tombol bg-info" href="/perbaiki_show/{{ $s->ID }}">Perbaiki</a>
                                </td>
                            @elseif (($s->fase > 1)&&($s->fase < 5))
                                <td><span class="tombol bg-slate-400">menunggu ...</span></td>
                                <td></td>
                            @elseif ($s->fase == 5)
                                <td><a class="tombol bg-info" href="/preview_surat/{{ $s->ID }}">Download</a></td>
                                <td></td>
                            @else
                                <td><a class="tombol bg-success" href="/verifikasi_pensiun/{{ $s->ID }}">Ajukan</a></td>
                            @endif

                            <td>{{ $s->tolak }}</td>

                            @if($s->fase == 1)
                                <td><a class="tombol bg-error" href="/del_pensiun/{{ $s->ID }}">Hapus</a></td>
                            @endif
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endcan
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
