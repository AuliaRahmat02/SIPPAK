<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-blue-200">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden w-1/2 flex">
            <div class="w-1/2">
                <img src="kantor_gubernur.png" alt="Building" class="h-full w-full object-cover">
            </div>
            <div class="w-1/2 p-8">
                <h2 class="text-2xl font-bold mb-4">Register</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="nip" id="nip" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">No. Handphone</label>
                        <input type="text" name="phone" id="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white font-bold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">REGISTER</button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Sudah punya akun? Login disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
