@extends('layout.nav')
@section('isi')
<h1 class="mt-10 mb-10 font-sans text-2xl font-bold text-center">
    FORM PENOLAKAN SURAT PENGANTAR
</h1>
    <form class="max-w-lg p-6 mx-auto space-y-4 bg-white rounded-md shadow-md" action="/tolak_surat"     method="POST">
        @csrf
        <!-- NIP -->
        <div>
            <input required readonly type="hidden" name="id"
                value="{{ $tolak }}"
                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>


        <!-- Nama Lengkap Kabiro -->
        <div>
            <label for="lama-cuti" class="block text-sm font-medium text-gray-700">Pesan Penolakan</label>
            <input required type="text" name="pesan"
                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >
            @error('pesan')
                <small class="text-error">{{ $message }}</small>
           @enderror
        </div>


        <div>
            <button type="submit" class="w-full px-4 py-2 font-medium text-white bg-error border border-transparent rounded-md shadow-sm ">
                Tolak Surat
            </button>
        </div>

        <div>
            <a class="w-full px-4 py-2 font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm" href="/back/{{ $tolak }}">
                Batal
            </a>
        </div>
    </form>
@endsection
