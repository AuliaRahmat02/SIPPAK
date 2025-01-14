@extends('layout.nav')
@section('isi')


        <h1 class="mt-10 font-sans text-2xl font-bold text-center">
            DATA KABIRO
        </h1>
        <?php
        $loop = 0;
        ?>
        <table class="mx-auto my-5 bg-white border-collapse border-separete border-spacing-3 ">
            <thead class="border-collapse rounded-lg border-3 bg-slate-400">
                <tr>
                    <th class="px-12 py-2">NIP</th>
                    <th class="px-12 py-2">Nama</th>
                    <th class="px-12 py-2">Biro</th>
                    <th class="px-12 py-2">G-mail</th>
                    <th class="px-3 py-2">TTDP</th>
                </tr>
            </thead>
            <tbody>
                    <tr class="hover:bg-slate-300 hover:border-blue-500">
                        <td class="px-3 py-3 select-none">{{ $nip}}</td>
                        <td class="px-3 py-3 select-none">{{ $nama}}</td>
                        <td class="px-3 py-3 select-none">{{ $biro}}</td>
                        <td class="px-3 py-3 select-none">{{ $email}}</td>
                        <td class="px-3 py-3 select-none size-40"><img src="data:{{ $tipedata}};base64,{{ base64_encode($ttd) }}" alt="ttd"></td>
                    </tr>

            </tbody>
        </table>



    <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action="{{ route('kabiro_proses') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- NIP -->
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Induk Pegawai (NIP)</label>
            <input required type="text" name="nip"
                value="{{ $nip }}"
                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
           @error('nip')
                <small class="text-error">{{ $message }}</small>
           @enderror
        </div>


        <!-- Nama Lengkap Kabiro -->
        <div>
            <label for="lama-cuti" class="block text-sm font-medium text-gray-700">Nama Lengkap Beserta Gelar</label>
            <input required type="text" name="nama"
                value="{{ $nama }}"
                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >
            @error('nama')
                <small class="text-error">{{ $message }}</small>
           @enderror
        </div>

        <!-- email kabiro -->
        <div>
            <label for="lama-cuti" class="block text-sm font-medium text-gray-700">G-mail</label>
            <input required type="gmail" name="gmail"
                value="{{ $email }}"
                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >
           @error("gmail")
                <small class="text-error">{{ $message }}</small>
           @enderror
        </div>
        <!-- Tanggal Mulai -->
        <div>
            <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">E-Signatur</label>
            <input required type="file" name="ttd" accept=".png, .jpeg" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error("ttd")
                <small class="text-error">{{ $message }}</small>
           @enderror
        </div>

        <div>
            <button type="submit" class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Upadate Data
            </button>
        </div>
    </form>
@endsection
