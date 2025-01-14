@php
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
@endphp

@extends('layout.nav')
@section('isi')

    @can('operator')
        @foreach ($items as $item)
            <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action="{{ route('uploadKGB') }}"
                method="GET">
                <!-- Nama -->
                {{-- <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="nama" name="nama"
            class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div> --}}

                <!-- NIP -->

                @foreach ($dataAdmin as $item)
                    <div>
                        <label for="nip" class="block text-sm font-bold text-black">Pesan Perbaikan</label>
                        <div class="p-2 mt-1 bg-white border border-red-600 rounded-md">
                            <label for="nip" class="block text-sm text-gray-900 font-small">{{ $item->pesan }}</label>
                        </div>
                    </div>
                @endforeach


                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
                    <input type="text" id="nama" name="nama"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->nama_pns }}" readonly>

                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" id="nip" name="nip"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->nip }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Pangkat Golongan</label>
                    <input type="text" id="pangkat" name="pangkat"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->pangkat . '/' . $item->golru_nm }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <input type="text" id="unitKerja" name="unitKerja"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->opd_nm }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Surat Cuti</label>
                    <input type="text" id="noSurat" name="noSurat"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="800.1.11.13/           /Adpim-2024" required>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nama Surat SK</label>
                    <input type="text" id="suratSK" name="suratSK"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="Sekretaris Daerah Provinsi Sumatera Barat" required>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor dan Tahun Surat SK</label>
                    <input type="text" id="noSK" name="noSK"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="No. 800/226/Adpim/2024 Tgl. 29 Februari 2024" required>
                </div>

                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Gaji Pokok Baru</label>
                    <input type="text" id="gaji" name="gajiPokok_N"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Gaji Pokok Lama</label>
                    <input type="text" id="gaji2" name="gajiPokok_B"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required>
                </div>
                <div>
                    <button type="submit"
                        class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit
                    </button>
                </div>
            </form>
        @endforeach
    @endcan


    @if (Auth::user()->can('jft') || Auth::user()->can('kabag') || Auth::user()->can('kabiro'))
        @foreach ($dataAdmin as $item)
            <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md"
                action="/verifKGB/{{ $item->nip }}" method="GET">
                <!-- Nama -->
                {{-- <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div> --}}

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
                    <input type="text" id="nama" name="nama"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->nama_pns }}" readonly>

                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" id="nip" name="nip"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->nip }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Pangkat Golongan</label>
                    <input type="text" id="pangkat" name="pangkat"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->pangkat . '/' . $item->golru_nm }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <input type="text" id="unitKerja" name="unitKerja"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->opd_nm }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor Surat Cuti</label>
                    <input type="text" id="noSurat" name="noSurat"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->noSurat }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nama Surat SK</label>
                    <input type="text" id="suratSK" name="suratSK"
                    class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ $item->suratSK }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Nomor dan Tahun Surat SK</label>
                    <input type="text" id="noSK" name="noSK"
                    class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ $item->noSK }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Gaji Pokok Baru</label>
                    <input type="text" id="gaji" name="gajiPokok_N"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->gajiBaru }}" readonly>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">Gaji Pokok Lama</label>
                    <input type="text" id="gaji" name="gajiPokok_N"
                        class="block w-full p-2 mt-1 bg-gray-300 border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ $item->gajiLama }}" readonly>
                </div>
                <div>
                    <button type="submit"
                        class="w-full px-4 py-2 font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Verifikasi
                    </button>
                </div>



            </form>
            <br>

            {{-- <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md"
                action="/printKGB/{{ $item->nip }}" method="GET">
                <div>
                    <label for="surat" class="block text-sm font-medium text-gray-700">Template Surat</label>
                    <button type="submit"
                        class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Download
                    </button>
                </div>
            </form> --}}


            <form class="max-w-lg p-6 mx-auto mt-5 space-y-4 bg-white rounded-md shadomax-w-md"
                action="/removeKGB/{{ $item->nip }}" method="GET">

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
    @endif
    <script>
        // Function to format the input as IDR currency with thousand separators and no decimal places
        function formatIDRCurrency(input) {
            // Remove any characters that are not digits
            let value = input.value.replace(/[^\d]/g, '');

            // Add thousand separators (dots) to the integer part
            let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Update the input field with the formatted value followed by ",-"
            input.value = formattedValue;
        }

        // Event listener to format the value as IDR currency as the user types
        document.getElementById('gaji').addEventListener('input', function() {
            formatIDRCurrency(this);
        });
        document.getElementById('gaji2').addEventListener('input', function() {
            formatIDRCurrency(this);
        });
    </script>
@endsection
