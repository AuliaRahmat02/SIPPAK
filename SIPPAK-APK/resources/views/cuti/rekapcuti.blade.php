@extends('layout.nav')
@section('isi')
<div class="h-12 p-1 text-right bg-white">
    <a href="/cuti/export" class="tombol">Export</a>
    <input type="text"
        class="inline-block w-72 mt-1 mr-40 h-9 px-2 py-1 rounded-lg shadow-xl ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
        placeholder="search..">
</div>
<h1 class="mt-10 font-sans text-2xl font-bold text-center">
    DAFTAR REKAPITULASI CUTI
</h1>
    <div class="mx-auto mt-10 w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th class="font-bold text-black">No</th>
                    <th class="font-bold text-black">Nama/NIP</th>
                    <th class="font-bold text-black">Unit Kerja</th>
                    <th class="font-bold text-black">Status</th>
                    <th class="font-bold text-black">Aksi</th>
                    <th class="font-bold text-black">Pesan</th>
                </tr>
            </thead>

            <tbody>
                <?php $count = 1; ?>
                @foreach ($data as $item)
                    <tr>

                        <td> {{ $count }} </td>
                        <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                        <td> {{ $item->opd_nm }} </td>
                        @can('operator')
                            @if ($item->verif == 1)
                                <td><button class="bg-green-500 cursor-not-allowed tombol" disabled>Sudah Diverifikasi</button>
                                </td>
                                <td><a class="tombol" href="/printCuti/{{ $item->nip }}">Print</a></td>
                            @elseif($item->verif == -1)
                                <td><a href="/cuti/formcuti/{{ $item->nip }}"class="bg-blue-500 tombol"> Ajukan Perbaikan</a>
                                </td>
                                <td><a class="tombol" href="/printCuti/{{ $item->nip }}">Print</a></td>
                            @else
                                @if ($item->fase == 1)
                                    <td><a href="/cuti/cutiVerif/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a></td>
                                    <td><a class="tombol" href="/printCuti/{{ $item->nip }}">Print</a></td>
                                @else
                                    <td><button class="cursor-not-allowed tombol" disabled>Menunggu Verifikasi</button></td>
                                    <td><a class="tombol" href="/printCuti/{{ $item->nip }}">Print</a></td>
                                @endif
                            @endif
                            <td>{{ $item->pesan }}</td>
                            </td>
                        @endcan
                        @cannot('operator')
                            <td>
                                @can('jft')
                                    @if ($item->fase == 2)
                                        <a href="/cuti/cutiVerif/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                    @else
                                        <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                    @endif
                                @endcan
                                @can('kabag')
                                    @if ($item->fase == 3)
                                        <a href="/cuti/cutiVerif/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                    @else
                                        <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                    @endif
                                @endcan
                                @can('kabiro')
                                    @if ($item->fase == 4)
                                        <a href="/cuti/cutiVerif/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                                    @else
                                        <button class="bg-gray-600 tombol">Sudah Di Verifikasi</button>
                                    @endif
                                @endcan
                                @if (!(Auth::user()->can('jft') || Auth::user()->can('kabag') || Auth::user()->can('kabiro')))
                                    @if ($item->verif == 1)
                            <td><button class="bg-green-500 cursor-not-allowed tombol" disabled>Sudah
                                    Diverifikasi</button>
                            </td>
                        @elseif ($item->verif == -1)
                            <a href="/cuti/cutiVerif/{{ $item->nip }}" class="bg-blue-500 tombol">Check</a>
                        @else
                            <td><button class="cursor-not-allowed tombol" disabled>Menunggu Verifikasi</button></td>
                    @endif
                    @endif
                    </td>
                    </td>

                    <td>
                        <a href="/printKGB/{{ $item->nip }}" class="bg-green-600 tombol">Print</a>
                    </td>
                    <td></td>
                @endcannot
                </tr>

                @php
                    $count++;
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('fungsi')
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
                        card.querySelector("[data-header]").textContent.toLowerCase().includes(
                            value) ||
                        card.querySelector("[data-body]").textContent.toLowerCase().includes(value);
                    card.classList.toggle("hide", !isVisible);
                });
            });
        });
    </script>
@endsection
