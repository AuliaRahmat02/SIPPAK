@extends('layout.Nonav')
@section('non')

    <div class="flex gap-1 items-center justify-center h-screen">
        <div class="bg-white p-6 shadow-lg rounded-lg overflow-hidden w-4/5 flex">
            <div class="w-49">
                <img src="pic/kantor_gubernur.jpg" alt="Building" class="h-full w-full object-cover">
            </div>
            <div class=" bg-blue-2 ml-1 inline-block p-8" style="width: 100%; padding:10px">
                <h2 class="text-2xl font-bold mb-4">Registrasi Kabiro</h2>
                <form action="/registKBR" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="number" placeholder="Masukkan NIP" name="nip" id="nip" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('nip')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" placeholder="Masukkan Nama Lengkap" name="nama" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('nama')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">G-mail</label>
                        <input type="email" placeholder="Masukkan alamat G-mail" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" placeholder="Masukkan Password" name="pass" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('pass')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">REGISTER</button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="/" class="text-sm text-gray-600 hover:text-gray-900">Sudah punya akun? <span class="text-blue-600 underline">Login disini</span> </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
