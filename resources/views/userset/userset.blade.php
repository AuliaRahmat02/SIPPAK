@extends('layout.nav')

@section('isi')

    @if (session()->has("200"))
        <script>alert('refresh data berhasil')</script>
    @elseif (session()->has("500"))
        <script>alert('refresh data gagal')</script>
    @endif
    <div class="text-center">
        <h1 class="mt-10 font-sans text-2xl font-bold text-center">
            Daftar User
        </h1>
        <?php
        $loop = 0;
        ?>
        <table class="mx-auto my-5 bg-white border-collapse border-separete border-spacing-3 ">
            <thead class="border-collapse rounded-lg border-3 bg-slate-400">
                <tr>
                    <th class="px-3 py-2">No</th>
                    <th class="px-12 py-2">NIP</th>
                    <th class="px-12 py-2">Nama</th>
                    <th class="px-12 py-2">Biro</th>
                    <th class="px-12 py-2">G-mail</th>
                    <th class="px-3 py-2">Hapus</th>
                </tr>
            </thead>
            @php
                $no = null;
            @endphp
            <tbody>
                @foreach ($admin as $user)
                    <tr class="hover:bg-slate-300 hover:border-blue-500">
                        <td class="px-1 py-3 select-none">
                            @php
                                $no++;
                                echo $no;
                            @endphp
                        </td>
                        <td class="px-3 py-3 select-none">{{ $user->NIP_User }}</td>
                        <td class="px-3 py-3 select-none">{{ $user->Nama_User }}</td>
                        <td class="px-3 py-3 select-none">{{ $user->biro }}</td>
                        <td class="px-3 py-3 select-none">{{ $user->email }}</td>
                        <td class="px-3 py-3 select-none">
                            <a href="/users/{{ $user->NIP_User }}" class="bg-red-500 tombol">Delete</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <a href="/buku" class="tombol bg-info">Refresh Data</a>
        @if ($reg != 1)
            <form class="inline" action="/userset/regkey" method="POST">
                @csrf
                <input class="hidden" type="password" name="set" value="REG">
                <input class="hidden" type="password" name="core" value="539">
                <button class="tombol bg-success" type="submit">set Registrasi</button>
            </form>
        @else
            <a href="/userset/delregkey" class="bg-red-500 tombol">unset Registrasi</a>
        @endif


        @if ($regOPR != 1)
            <form class="inline" action="/userset/regkeyOPR" method="POST">
                @csrf
                <input class="hidden" type="password" name="set" value="OPR">
                <input class="hidden" type="password" name="core" value="555">
                <button class="tombol bg-success" type="submit">set Registrasi Operator</button>
            </form>
        @else
            <a href="/userset/delregkeyOPR" class="bg-red-500 tombol">unset Registrasi Operator</a>
        @endif


        @if ($regJFT != 1)
            <form class="inline" action="/userset/regkeyJFT" method="POST">
                @csrf
                <input class="hidden" type="password" name="set" value="JFT">
                <input class="hidden" type="password" name="core" value="531">
                <button class="tombol bg-success" type="submit">set Registrasi JFT</button>
            </form>
        @else
            <a href="/userset/delregkeyJFT" class="bg-red-500 tombol">unset Registrasi JFT</a>
        @endif

        @if ($regKBG != 1)
            <form class="inline" action="/userset/regkeyKBG" method="POST">
                @csrf
                <input class="hidden" type="password" name="set" value="KBG">
                <input class="hidden" type="password" name="kbg" value="532">
                <button class="tombol bg-success" type="submit">set Registrasi Kabag</button>
            </form>
        @else
            <a href="/userset/delregkeyKBG" class="bg-red-500 tombol">unset Registrasi Kabag</a>
        @endif

        @if ($regKBR != 1)
            <form class="inline" action="/userset/regkeyKBR" method="POST">
                @csrf
                <input class="hidden" type="password" name="set" value="KBR">
                <input class="hidden" type="password" name="kbr" value="533">
                <button class="tombol bg-success" type="submit">set Registrasi Kabiro</button>
            </form>
        @else
            <a href="/userset/delregkeyKBR" class="bg-red-500 tombol">unset Registrasi Kabiro</a>
        @endif

        @if ($forgot != 1)
            <form class="inline" action="/userset/forgkey" method="POST">
                @csrf
                <input class="hidden" type="text" name="set" value="FRG">
                <input class="hidden" type="text" name="codes" value="935">
                <button class="tombol bg-success" type="submit">set lupa password</button>
            </form>
        @else
            <a href="/userset/delforgkey" class="bg-red-500 tombol">unset lupa password</a>
        @endif

        @if (session("T"))
            <div class="inline-block p-5 py-2 text-black bg-green-300 border-green-700  border-2 rounde-lg">
                {{ session("T") }}
            </div>
        @endif



        {{-- <!-- The button to open modal -->
        <label for="my_modal_6" class="btn">open modal</label>



        <button class="btn" onclick="my_modal_4.showModal()">open modal</button>

        <dialog id="my_modal_4" class="modal">
            <div class="w-11/12 max-w-5xl modal-box">
                <div class="flex" style="align-items:center;justify-content:center">
                    <embed src="/template/template.docx" type="application/pdf" height="800" width="5000">
                </div>
                <div class="modal-action">
                    <form method="dialog">
                        <!-- if there is a button, it will close the modal -->
                        <button class="btn">Close</button>
                    </form>
                </div>
            </div>
        </dialog> --}}
    </div>
@endsection
