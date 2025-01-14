@php
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
@endphp


@extends('layout.nav')
@section('isi')
    <div class="h-12 mt-2 text-right bg-white">
        <input type="text"
            id="searchInput"
            class="inline-block w-72 mt-1 mr-40 h-9 px-2 py-1 rounded-lg shadow-xl ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
            placeholder="search..">
    </div>

    <h1 class="mt-10 font-sans text-2xl font-bold text-center">
        KENAIKAN GAJI BERKALA
    </h1>

    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">


            @can('operator')
                <form action="{{ route('kgb.view') }}" method="GET" class="my-3">
                    <div>
                        <label class="font-bold" for="">Bulan : {{ $bulan }}</label>
                    </div>
    
                    <div class="mt-2">
                        <label class="font-bold" for="month">Bulan:</label>
                        <select class="input input-bordered input-success w-full max-w-xs " name="month" id="month">
                            @foreach ($months as $value => $name)
                                <option value="{{ $value }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="tombol bg-success">Filter</button>
                    </div>
                </form>

                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="font-bold text-black">No</th>
                            <th class="font-bold text-black">Nama/NIP</th>
                            <th class="font-bold text-black">Pangkat/Gol</th>
                            <th class="font-bold text-black">Unit Kerja</th>
                            @if (Carbon::now()->month == $indeksMonth)
                                <th class="font-bold text-black">Pengajuan Surat</th>
                            @else()
                                <th class="font-bold text-black">Tidak Ada</th>
                            @endif
                            <th class="font-bold text-black">Print Surat</th>
                            <th class="font-bold text-black">Pesan</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach ($buku as $item)
                            <tr class="hover">
                                <th> {{ $count }} </th>
                                <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                                <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} <br> {{ \Carbon\Carbon::parse($item->tmt_gaji_N)->format('j F Y')  }} </td>
                                <td> {{ $item->jabatan_nm }} </td>
                                @if (isset($item->fase))
                                    @if ($item->verif == 1)
                                        <td>
                                            <button class="bg-gray-600 tombol">SudahDiverifikasi</button>
                                        </td>
                                        <td>
                                            <a href="/printKGB/{{ $item->nip }}" class="bg-green-600 tombol">Print</a>
                                        </td>
                                    @elseif ($item->verif == -1)
                                        <td>
                                            <a class="bg-success tombol" href="/formkgb/{{ $item->nip }}">Ajukan
                                                Perbaikan</a>
                                        </td>
                                        <td>
                                            <button class="bg-gray-600 tombol">print</button>
                                        </td>
                                    @elseif ($item->fase != 0)
                                        <td>
                                            <button class="bg-gray-600 tombol">Menunggu Verifikasi</button>
                                        </td>
                                        <td>
                                            <a href="/printKGB/{{ $item->nip }}" class="bg-green-600 tombol">print</a>
                                            {{-- <button class="bg-gray-600 tombol">print</button> --}}
                                        </td>
                                    @else
                                        <td>
                                            <a class="bg-success tombol" href="/formkgb/{{ $item->nip }}">ajukan</a>
                                        </td>
                                        <td>
                                            <button class="bg-gray-600 tombol">Print</button>
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        <a class="bg-success tombol" href="/formkgb/{{ $item->nip }}">ajukan</a>
                                    </td>
                                    <td>
                                        <button class="bg-gray-600 tombol">Print</button>
                                    </td>
                                @endif
                                <td>
                                    @if ($item->pesan == 0)
                                    @else
                                        {{ $item->pesan }}
                                    @endif
                                </td>
                                {{-- @endif --}}

                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            @endcan

            @if (Gate::any(['jft','kabag','kabiro']))
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="font-bold text-black">No</th>
                            <th class="font-bold text-black">Nama/NIP</th>
                            <th class="font-bold text-black">Status Verifikasi</th>
                            <th class="font-bold text-black">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach ($buku as $item)
                            @if (
                                (Auth::user()->can('jft') && ($item->fase == 1 || $item->fase > 1)) ||
                                    (Auth::user()->can('kabag') && ($item->fase == 2 || $item->fase > 2)) ||
                                    (Auth::user()->can('kabiro') && ($item->fase == 3 || $item->fase > 3)))
                                <tr class="hover">
                                    <td> {{ $count }} </td>
                                    <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                                    <td>
                                        @can('jft')
                                            @if ($item->fase == 1)
                                                <a href="/formkgb/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                            @else
                                                <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                            @endif
                                        @endcan
                                        @can('kabag')
                                            @if ($item->fase == 2)
                                                <a href="/formkgb/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                            @else
                                                <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                            @endif
                                        @endcan
                                        @can('kabiro')
                                            @if ($item->fase == 3)
                                                <a href="/formkgb/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                            @else
                                                <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        <a href="/printKGB/{{ $item->nip }}" class="bg-green-600 tombol">Print</a>
                                    </td>


                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
@endsection
{{-- @section('fungsi')
<style>
    .hide {
display: none;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector("[data-search]");
        const userCards = document.querySelectorAll("[data-user-card]");

        searchInput.addEventListener("input", e => {
            const value = e.target.value.toLowerCase();

            userCards.forEach(card => {
                const isVisible =
                    card.querySelector("[data-header]").textContent.toLowerCase().includes(value) ||
                    card.querySelector("[data-body]").textContent.toLowerCase().includes(value);
                card.classList.toggle("hide", !isVisible);
            });
        });
    });
</script>
@endsection --}}
