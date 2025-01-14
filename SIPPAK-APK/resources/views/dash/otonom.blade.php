@extends('layout.nav')

@section('isi')
<header class="centered-header">
    <div class="p-10">
        <normal class="font-normal ">Selamat Datang Di</normal>
        <header class="centered-headerr">
            <h1 class="text-7xl">S I P P A K</h1>
            <h5 class="p-3 text-5xl">SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT</h5>
    </div>

</header>


        @can("opPemerintahan")
            <div class="my-6 text-center">
                @if ($naik[0] != 0)
                    <a href="/naikpangkat" role="alert"
                        class="inline-block mb-2 my-auto  w-[60%] border-2 alert border-slate-300 shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-info shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Ada {{ $naik[0] }} orang yang akan naik pangkat di bulan {{ $naik[1] }}.</span>
                    </a>
                @endif
            </div>
        @endcan

    <div class="text-right bg-slate-200 h-14 p-2 shadow-xl">
        <input type="text" id="search" data-search
            class="inline-block px-2 mr-8 py-1 h-11 w-80 rounded-lg shadow-xl focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
            placeholder="NIP, nama, golongan, jabatan,">
    </div>
    <div class="inline-block w-[80%] ml-40 my-5">
        @foreach ($data as $dat)
            <div data-user-card class="collapse collapse-arrow bg-slate-200 mb-5 shadow-xl">
                <input type="radio" name="my-accordion-2" checked="checked" />
                <div data-header class="collapse-title text-xl font-medium">{{$dat->nama_pns}}</div>
                <div data-body class="collapse-content">
                    <ul>
                        <li><b>NIP : </b>{{$dat->nip}}</li>
                        <li><b>Golongan : </b>{{ $dat->pangkat }} ({{$dat->golru_nm}})</li>
                        <li><b>Jabatan Sekarang : </b>{{$dat->jabatan_nm}}</li>
                    </ul>

                    {{--tombol link untuk menuju data profil pegawai --}}
                <div>
                    <a class="tombol bg-info" href="/dashboard/datapegawai/{{ $dat->nip }}">Data selengkapnya</a>
                </div>

                    @can('opPemerintahan')

                        <div class="text-center block w-full">
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">CUTI</div>
                                @if ($dat->cuti != true)
                                    <a class="tombol bg-success" href="/cuti/formcuti/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">PENSIUN</div>
                                @if ($dat->pensiun != true)
                                    <a class="tombol bg-success" href="/Ajukan_Pensiun/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">IJAZAH DAN GELAR</div>
                                @if ($dat->ijazah != true)
                                    <a class="tombol bg-success" href="/Ajukan_Ijazah/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">KARTU ISTRI/SUAMI</div>
                                @if ($dat->kartu != true)
                                    <a class="tombol bg-success" href="/Ajukan_Kartu/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">SATYALENCANA</div>
                                @if ($dat->satyalencana != true)
                                    <a class="tombol bg-success" href="/Ajukan_Sat/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                            <div class="inline-block mx-5 text-center p-3 bg-slate-100 mt-2 rounded-xl shadow-lg">
                                <div class="font-bold">BELAJAR</div>
                                @if ($dat->belajar != true)
                                    <a class="tombol bg-success" href="/Ajukan_Belajar/{{ $dat->nip }}">Ajukan</a>
                                @else
                                    <span class="tombol bg-warning" class="font-bold">menunggu...</span>
                                @endif
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        @endforeach
    </div>


    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .centered-header {
            text-align: center;
            font-family: Brush Script MT;
            color: #f0f0f0;
        }

        .centered-headerr {
            font-family: Monaco;
        }

        .reminder {
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
            margin-top: 60px;
        }

        .reminder-item {
            background-color: #ffffff;
            border: 1px solid #e3dfdf;
            border-radius: 10px;
            padding: 15px;
            border: 2px solid #000000;
            margin: 10px 0;
            text-align: center;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container .press1 {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 80px;
            max-width: 0%;
            margin: 20px;
            padding: 20px;
        }

        .centered-header {
            width: 100%;
            height: 30vh;
            background-image: url('../pic/japan2.jpg');
            font-size: xx-large;
            font-weight: bold;

        }

        .centered-main {
            padding: 20px;
        }

        .reminder {
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .press1 div {
            display: inline-block;
            margin: 30px;
            width: 300px;
            margin-top: -10px;
            border: 2px solid #000000;
            border-radius: 10px;
            background-color: gray;
            box-shadow: 0px 10px 50px 4px rgb(171, 171, 171)
        }

        .press1 img {
            border-radius: 10px;
        }

        .logo {
            text-align: left;
        }
    </style>
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
