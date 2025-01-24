

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

<main class="block w-full">
    <div class="my-10">
        <div class="flex mx-auto max-w-[1233px] flex-wrap gap-10">

            <a href="/kartu">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/bz.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">KARTU ISTRI/SUAMI</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
            <a href="/kenaikanpangkat">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/Naik Pangkat.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">KENAIKAN PANGKAT</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
            <a href="/belajar">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/open-book.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">IZIN BELAJAR</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
            <a href="/ijazah">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/ijazah.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">PENYESUAIAN IJAZAH DAN GELAR</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
            <a href="/pensiun">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/document.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">PENSIUN</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
            <a href="satyalencana">
                <div class="shadow-xl card card-compact bg-base-100 w-96">
                    <figure>
                        <img
                        class="p-5 size-52"
                        src="../pic/badge.png"
                        alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">SATYALENCANA</h2>
                        <div class="card-actions justify-end">
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>


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


            .centered-header {
                width: 100%;
                height: 30vh;
                background-image: url('../pic/japan2.jpg');
                font-size: xx-large;
                font-weight: bold;

            }


            .reminder {
                margin-bottom: 20px;
            }

            .logo {
                text-align: left;
            }
        </style>
@endsection

