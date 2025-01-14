@extends('layout.Nonav')

@section('non')
    
    <div>
        <div class="bg-blue-2 flex items-center justify-center h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
                <img src="pic/kantor_gubernur.jpg" alt="Background" class="absolute inset-0 h-full w-full object-cover opacity-50 z-0">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold mb-4 text-center">Lupa Password</h2>
                    <form action="/verify" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                            <input type="text" name="nip" id="nip" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="masukkan NIP">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

