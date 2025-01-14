@extends('layout.nav')
@section('isi')
    <header class="centered-header">
        <div class="p-3">
            <normal class="font-normal ">Selamat Datang Di</normal>
            <header class="centered-headerr">
                <normal class="font-bold">Sistem Informasi Pelayanan dan Pengelolaan Administrasi  Kepegawaian</normal>
                <h1 class="p-2 text-6xl">S I P P A K</h1>
                <h5 class="p-2 text-5xl">SEKRETARIAT DAERAH PROVINSI SUMATERA BARAT</h5>
        </div>

    </header>

    <main class="centered-main">
        @if (Gate::any(['jft','kabag','kabiro']))
            @foreach ($pengantar as $p=>$spil)
                @if ($spil['surat'] != 0)
                <div class="reminder">
                    <a href="{{ $spil['link'] }}" role="alert" class="mb-2 border-2 alert border-slate-300">
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="w-6 h-6 stroke-info shrink-0">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Ada {{$spil['surat'] }} surat pengantar {{ $spil['nama'] }} yang perlu di verifikasi</span>
                    </a>
                </div>
                @endif
            @endforeach
        @endif
        @can('operator')
            <div class="reminder">
                @if ($kenaikan != 0)
                    <a href="/kenaikanpangkat" role="alert" class="mb-2 border-2 alert border-slate-300">
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="w-6 h-6 stroke-info shrink-0">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Ada {{ $kenaikan }} orang yang mengajukan naik dari TU biro pangkat di bulan {{ $naik[1] }}.</span>
                    </a>
                @endif

                @if ($naikkgb[0] != null)
                    @for ($i=1;$i < 3; $i++)
                    <a href="/kgbDash{{$i}}" role="alert" class="mb-2 border-2 alert border-slate-300" >
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="w-6 h-6 stroke-info shrink-0">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="flex flex-col">
                            <span>{{ $naikkgb[$i*2] }} orang KGB di bulan {{ $naikkgb[$i*2+1] }}.</span>
                            <span class="ml-5">
                                <ul style="list-style-type: circle;">
                                    {{-- @if ($i==0) --}}
                                        @if ($naikkgb[6+$i][0] > 0 )
                                            <li>{{ $naikkgb[6+$i][0] }} orang sudah di verifikasi.</li>
                                        @endif
                                        @if ($naikkgb[6+$i][1] > 0)
                                            <li>{{ $naikkgb[6+$i][1] }} orang menunggu verifikasi</li>
                                        @endif
                                        @if ($naikkgb[6+$i][2] > 0)
                                            <li>{{ $naikkgb[6+$i][2] }} orang harus melakukan perbaikan </li>
                                        @endif
                                    {{-- @endif --}}
                                </ul>
                            </span>

                        </span>
                    </a>
                    @endfor

                @endif
            </div>

            <div class="form-container">
                <div class="press1">
                    <div><a href="/dashboard/pemerintahan">
                            <img src="../pic/1.png" alt="Biro Image 1">
                        </a></div>
                    <div><a href="/dashboard/hukum">
                            <img src="../pic/2.png" alt="Biro pic 2">
                        </a></div>
                    <div><a href="/dashboard/kesra">
                            <img src="../pic/3.png" alt="Biro pic 3">
                        </a></div>
                </div>
            </div>

            <div class="form-container">
                <div class="press1">
                    <div><a href="/dashboard/perekonomian">
                            <img src="../pic/4.png" alt="Biro pic 4">
                        </a></div>
                    <div><a href="/dashboard/pbj">
                            <img src="../pic/5.png" alt="Biro pic 5">
                        </a></div>
                    <div><a href="/dashboard/adpem">
                            <img src="../pic/6.png" alt="Biro pic 6">
                        </a></div>
                </div>
            </div>

            <div class="form-container">
                <div class="press1">
                    <div><a href="/dashboard/organisasi">
                            <img src="../pic/7.png" alt="Biro pic 7">
                        </a></div>
                    <div><a href="/dashboard/umum">
                            <img src="../pic/8.png" alt="Biro pic 8">
                        </a></div>
                    <div><a href="/dashboard/adpim">
                            <img src="../pic/9.png" alt="Biro pic 9">
                        </a></div>
                </div>
            </div>
        </main>
        @endcan


        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .centered-headerr {
                font-family: Monaco;
            }

            .centered-main {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin-top: -40px;
            }

            .reminder {
                width: 80%;
                max-width: 600px;
                margin-bottom: 20px;
                margin-top: 60px;
            }


            .centered-header {
                width: 100%;
                height: 30vh;
                background-image: url('../pic/japan2.jpg');
                font-size: xx-large;
                font-weight: bold;
                text-align: center;
                font-family: Brush Script MT;
                color: #f0f0f0;

            }

            .centered-main {
                padding: 20px;
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
