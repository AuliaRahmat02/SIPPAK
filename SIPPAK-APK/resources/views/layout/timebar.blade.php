<div class="z-[1] flex justify-between select-none px-5 text-right text-black w-full fixed font-bold font-sans transisiwarna h-12 leading-[40px]">
    <a href="/dashboard" class="flex items-center">
            <img src="../../pic/losum.png" alt="Logo" class="h-8 mr-2"> <!-- Logo gambar dengan margin kanan -->
            <span class="text-lg font-bold font-serif">S I P P A K</span> <!-- Teks dengan ukuran dan gaya font -->
        </a>
    @auth
        {{-- user container start --}}
        <div class="flex justify-center">
            <img src="../../pic/user.png" alt="user" class="flex-none inline-block p-2 leading-[40px]">
            <p class="transition-all duration-150 text-black text-sm leading-[50px] select-none text">{{ auth()->user()->Nama_User }}({{ auth()->user()->NIP_User }}) - {{ auth()->user()->biro }}</p>
        </div>
    @else
        {{-- user container start --}}
        <div class="flex justify-center">
            <img src="../../pic/user1.png" alt="user" class="flex-none inline-block p- leading-[40px]">
            <p class="transition-all duration-150 text-black text-sm leading-[40px] select-none text "></p>
        </div>
    @endauth

    {{-- user container end --}}
    <div>
        <span>{{ \Carbon\carbon::now()->translatedFormat("l j F Y") }}</span>
    </div>
</div>













