@extends('layout.Nonav')
@section('non')
    
    <div>
        <div class="bg-blue-2 mt-p flex items-center justify-center h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Buat Sandi Baru</h2>
                <form action="/ubah" method="POST" class="text-center w-72">
                    @csrf
                    <div class="mb-4">
                        <input type="hidden" name="nip" value="{{$nip}}">
                            
                        <input type="password" placeholder="Masukkan Sandi Baru" class="w-full rounded-md p-2 border-slate-400 border-2 focus:border-blue-400 focus:outline-none" id="password1" name="pass1" required>
                        <div class="text-left mb-4">
                            <input type="checkbox" id="show1">
                            <label for="showPassword" class="ms-2">Lihat Sandi</label>
                        </div>
                        @error('pass1')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    
                        <input type="password" placeholder="Konfirmasi Sandi Baru" class="w-full rounded-md p-2 border-slate-400 border-2 focus:border-blue-400 focus:outline-none" id="password2" name="pass2" required>
                        <div class="text-left mb-4">
                            <input type="checkbox" id="show2">
                            <label for="showPassword" class="ms-2">Lihat Sandi</label>
                        </div>
                        @error('pass1')
                            <small class="text-red-400">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Verifikasi
                    </button>
                </form>
            </div>
        </div>
            
    </div>

    <script>
        document.getElementById('show1').addEventListener('change', function () {
            var passwordInput = document.getElementById('password1');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });

        document.getElementById('show2').addEventListener('change', function () {
            var passwordInput = document.getElementById('password2');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>

@endsection
    

