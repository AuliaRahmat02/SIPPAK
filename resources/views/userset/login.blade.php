@extends('layout.Nonav')
@section('non')

<div>
    <div class="bg-blue-2 flex items-center justify-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative overflow-hidden">
            <img src="pic/kantor_gubernur.jpg" alt="Background" class="absolute inset-0 h-full w-full object-cover opacity-25 z-0 rounded-lg">
            <div class="relative z-10 border-black p-6 rounded-lg">
                <h1 class="text-3xl font-bold mb-1 text-left">Welcome back,</h1>  <h2>  silahkan login untuk mengakses akun anda. </h2> <br> <br>
                <h1 class="text-3xl font-bold mb-4 text-left">Login</h1>
                <form action="/Login" method="POST">
                    @csrf
                    <div class="mb-4">
                        @if (session()->has('loginError'))
                            <small class="text-lg text-red-500">{{ session('loginError') }}</small><br>
                        @endif
                        {{-- @error('username')
                            <small class="text-red-500">{{ $message }}</small><br>
                        @enderror
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small><br>
                        @enderror --}}
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="username" id="nip" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="masukkan NIP">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="masukkan Password">
                    </div>

                    @if ($forgot === 1)
                        <div class="mb-4 text-left">
                            <span class="text-black">Lupa Password?</span>
                            <a href="/lupapassword" class="text-sm hover:underline">
                                <span class="text-red-500">lupa password</span>
                            </a>
                        </div>
                    @endif


                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white font-bold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">LOGIN</button>
                    </form>

                    @if($reg == 1)
                        <div class="mt-4 text-left">
                            <span class="text-black">Belum punya akun?</span>
                            <a href="/Registrasi" class="text-sm hover:underline">
                                <span class="text-red-500">Registrasi!</span>
                            </a>
                        </div>
                    @endif

                    @if($regOPR == 1)
                        <div class="mt-4 text-left">
                            <span class="text-black">Khusus untuk Operator</span>
                            <a href="/RegistrasiOPR" class="text-sm hover:underline">
                                <span class="text-red-500">Registrasi Operator</span>
                            </a>
                        </div>
                    @endif

                    @if($regJFT == 1)
                        <div class="mt-4 text-left">
                            <span class="text-black">Khusus untuk JFT</span>
                            <a href="/RegistrasiJFT" class="text-sm hover:underline">
                                <span class="text-red-500">Registrasi JFT</span>
                            </a>
                        </div>
                    @endif

                    @if($regKBG == 1)
                        <div class="mt-4 text-left">
                            <span class="text-black">Khusus untuk Kabag</span>
                            <a href="/RegistrasiKBG" class="text-sm hover:underline">
                                <span class="text-red-500">Registrasi Kabag</span>
                            </a>
                        </div>
                    @endif
                    @if($regKBR == 1)
                        <div class="mt-4 text-left">
                            <span class="text-black">Khusus untuk Kabiro</span>
                            <a href="/RegistrasiKBR " class="text-sm hover:underline">
                                <span class="text-red-500">Registrasi Kabiro</span>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
