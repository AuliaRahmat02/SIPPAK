@extends('layout.nav')
@section('isi')
    @if (Auth::user()->can('jft') || Auth::user()->can('kabag') || Auth::user()->can('kabiro'))
        @foreach ($dataAdmin as $data)
            <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md"
                action="/cuti/verif/{{ $data->nip }}" method="GET">
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
        @endforeach
        <div>
            <button type="submit"
                class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Submit
            </button>
        </div>
        </form>
    @elseif (Auth::user()->can('opAdpim'))
        <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action={{ route('proses_cuti_adpim') }}
            method="POST">
            @csrf

            @foreach ($dataAdmin as $item)
                <div>
                    <label for="nip" class="block text-sm font-bold text-black">Pesan Perbaikan</label>
                    <div class="p-2 mt-1 bg-white border border-red-600 rounded-md">
                        <label for="Perbaikan" class="block text-sm text-gray-900 font-small">{{ $item->pesan }}</label>
                    </div>
                </div>
            @endforeach
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
                    value="         /            / Adpim-2024">
            </div>

            {{-- jenis cuti --}}
            <div>
                <label for="jeniscuti" class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                <select id="jeniscuti" name="jenis"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="1">Cuti Tahunan</option>
                    <option value="2">Cuti Sakit</option>
                    <option value="3">Cuti Melahirkan</option>
                    <option value="4">Cuti Alasan Penting</option>
                    <option value="5">Cuti di Luar Tanggungan Negara</option>
                    <option value="6">Cuti Besar</option>
                </select>
                @if (session()->has('nip'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="lama-cuti" class="block text-sm font-medium text-gray-700">Lama Cuti (hari)</label>
                <input required type="text" id="lamacuti" name="hari" value="5 (lima)"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('hari'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input required type="date" id="tanggalmulai" name="mulai"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('mulai'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input required type="date" id="tanggalmulai" name="akhir"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('akhir'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <button type="submit"
                    class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                </button>
            </div>
        </form>
    @else
        <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action={{ route('proses_cuti') }}
            method="POST">
            @csrf

            @foreach ($dataAdmin as $item)
                <div>
                    <label for="nip" class="block text-sm font-bold text-black">Pesan Perbaikan</label>
                    <div class="p-2 mt-1 bg-white border border-red-600 rounded-md">
                        <label for="Perbaikan" class="block text-sm text-gray-900 font-small">{{ $item->pesan }}</label>
                    </div>
                </div>
            @endforeach
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
                    value="         /            / Adpim-2024">
            </div>

            {{-- jenis cuti --}}
            <div>
                <label for="jeniscuti" class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                <select id="jeniscuti" name="jenis"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="1">Cuti Tahunan</option>
                    <option value="2">Cuti Sakit</option>
                    <option value="3">Cuti Melahirkan</option>
                    <option value="4">Cuti Alasan Penting</option>
                    <option value="5">Cuti di Luar Tanggungan Negara</option>
                    <option value="6">Cuti Besar</option>
                </select>
                @if (session()->has('nip'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="lama-cuti" class="block text-sm font-medium text-gray-700">Lama Cuti (hari)</label>
                <input required type="text" id="lamacuti" name="hari" value="5 (lima)"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('hari'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input required type="date" id="tanggalmulai" name="mulai"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('mulai'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <label for="tanggalmulai" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input required type="date" id="tanggalmulai" name="akhir"
                    class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if (session()->has('akhir'))
                    <small>{{ $message }}</small>
                @endif
            </div>

            <div>
                <button type="submit"
                    class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                </button>
            </div>
        </form>
    @endif
@endsection
