<!DOCTYPE html>
<html lang="in" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../../pic/losum.png" type="image/x-icon">
    @vite('resources/css/app.css')
    @vite('resources/css/footer.css')
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
    />
    <title>SIPPAK | {{ $title }}</title>
</head>

<body class="font-sans" style="background-image: url('../../pic/bekron3.jpg'); background-size: width: 1920px height: 1080px ;">
     @include('layout.timebar')

    {{-- menampilkan navbar --}}
    <div class="z-30">
        @include('layout.navbar')
    </div>
    {{-- timebar --}}

    @include('layout.content')

    {{-- script javascript untuk mengatur slidign pada navbar --}}
    <script>
        const navigasi = document.querySelector('.navigasi')
        const seen = document.querySelectorAll('.seen')

        function onToggleMenu(e) {
            e.name = e.name === 'panah' ? 'close' : 'panah'
            navigasi.classList.toggle('w-56')
            seen.forEach(function(element) {
                element.classList.toggle('scale-0')
            });
        }
    </script>
    @yield('fungsi')
</body>

</html>
