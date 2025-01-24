@extends('layout.nav')
@section('isi')
    @foreach ($dataAdmin as $data)
        <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action="/cuti/verif/{{ $data->nip }}"
            method="GET">
            @csrf
            <!-- NIP -->
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Induk Pegawai (NIP)</label>
                <input required type="text" id="nip" name="nip" value="{{ $nip }}"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    readonly>
                @if (session()->has('nip'))
                    <small>{{ $message }}</small>
                @endif
            </div>
            <div>
                <label for="noSurat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                <input required type="text" id="nomorSurat" name="nomorSurat"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ $data->nomorSurat }}" readonly>
                @if (session()->has('nomorSurat'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            {{-- jenis cuti --}}
            <div>
                <label for="jeniscuti" class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                <input required type="text" id="jenisCuti" name="jenisCuti"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="Cuti {{ $jenisCuti[$data->jenis] }}" readonly>
                @if (session()->has('nip'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="lama-cuti" class="block text-sm font-medium text-gray-700">Lama Cuti (hari)</label>
                <input required type="text" id="lamacuti" name="hari" value="{{ $data->hari }}"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('hari'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input required type="date" id="tanggalmulai" name="mulai" value="{{ $data->mulai }}" readonly
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('mulai'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input required type="date" id="tanggalmulai" name="akhir" value="{{ $data->selesai }}" readonly
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('akhir'))
                    <small>{{ $message }}</small>
                @endif
            </div>
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 font-medium text-white bg-green-500 border border-transparent rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Verifikasi
                </button>
            </div>
        </form>
        <br>

        {{-- <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md"
            action="/printCuti/{{ $data->nip }}" method="GET">
            <div>
                <label for="surat" class="block text-sm font-medium text-gray-700">Template Surat</label>
                <button type="submit"
                    class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Download
                </button>
            </div>



        </form> --}}


        <form class="max-w-lg p-6 mx-auto mt-5 space-y-4 bg-white rounded-md shadomax-w-md"
            action="/tolakCuti/{{ $data->nip }}" method="GET">

            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700">Saran perbaikan</label>
                <input type="text" id="pesan" name="pesan"
                    class="block w-full p-2 mt-1 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
            </div>
            <button type="submit"
                class="w-full px-4 py-2 font-medium text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Perbaikan
            </button>
        </form>
    @endforeach
@endsection
