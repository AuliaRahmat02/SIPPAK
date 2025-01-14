@extends('layout.nav')
@section('isi')
<div class="h-12 mt-2 text-right bg-white">
    <input type="text"
        id="searchInput"
        class="inline-block w-72 mt-1 mr-40 h-9 px-2 py-1 rounded-lg shadow-xl ring-2 ring-slate-500 border-slate-500 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500"
        placeholder="search..">
</div>

    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%] p-10 rounded-xl shadow-xl odd:bg-white even:bg-slate-50 outline-1">

            {{-- ========================================bagian khusus jft ================================================== --}}
            @can('jft')
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="font-bold text-black">No</th>
                            <th class="font-bold text-black">Nama/NIP</th>
                            <th class="font-bold text-black">golru</th>
                            <th class="font-bold text-black">Pangkat/Gol</th>
                            <th class="font-bold text-black">Unit Kerja</th>
                            <th class="font-bold text-black">Pengajuan surat</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        <?php $count = 1; ?>
                        @foreach ($buku as $item)
                            <tr class="hover">
                                <th> {{ $count }} </th>
                                <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                                <td>{{ $item->tmt_golru_N }}</td>
                                <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} <br> {{ $item->tmt_pns }} </td>
                                <td> {{ $item->jabatan_nm }} </td>
                                <td><a class="tombol" href="">Ajukan</a></td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            @endcan

            {{-- ============================================bagian khusu opAdpim=============================== --}}
            <form action="{{ route('naik.view') }}" method="GET" >
                <div>
					<h1 class="font-bold">
						Bulan : {{ $bulan }}
					</h1>
                </div>
				
				<div class="my-5">
					<label class="font-bold" for="month"> Pilih :</label>

					<select class="input input-bordered input-success w-full max-w-xs" name="month" id="month">
						@foreach ($months as $value => $name)
							<option value="{{ $value }}">{{ $name }}</option>
						@endforeach
					</select>
	
	
					<button type="submit" class="tombol bg-info">Filter</button>
                    <a class="tombol bg-info" href="/naikpangkat">Reset</a>
				</div>

            </form>

            <div>
                <button id="check" type="submit" class="tombol bg-warning cursor-pointer">Batal</button>
            </div>

            {{-- form ======================================================--}}
            <form action="/birosend" method="POST">
                @csrf
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="font-bold text-black">No</th>
                            <th class="font-bold text-black">Nama/NIP</th>
                            <th class="font-bold text-black">golru</th>
                            <th class="font-bold text-black">Pangkat/Gol</th>
                            <th class="font-bold text-black">Biro</th>
                            @if ($setSurat == 1)
                                <th class="font-bold text-black">Pilih</th>
                            @endif
                            <th class="font-bold text-black">Profil</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        <?php $count = 1; ?>
                        @foreach ($buku as $item)
                            <tr class="hover">
                                <th> {{ $count }} </th>
                                <td>{{ $item->nama_pns }} <br> {{ $item->nip }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tmt_golru_N)->format('j F Y')}}</td>
                                <td>{{ $item->pangkat }} <br>{{ $item->golru_nm }} <br> {{ $item->tmt_pns }} </td>
                                <td> {{ $item->opd_nm }} </td>
								@if ($setSurat == 1)
	                                <td><input class="frs checkbox checkbox-success" type="checkbox" name="nip[]" value="{{ $item->nip }}" checked ></td>
								@endif
                                <td><a class="tombol bg-info" href="/profil/{{ $item->nip }}">profil</a></td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                <Button class="tombol bg-success" type="submit">Ajukan</Button>
            </form>
            {{-- form========================= --}}
        </div>
    </div>
@endsection
@section('fungsi')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var searchText = this.value.toLowerCase();
            var tableRows = document.getElementById('tableBody').getElementsByTagName('tr');

            for (var i = 0; i < tableRows.length; i++) {
                var rowText = tableRows[i].textContent.toLowerCase();
                if (rowText.includes(searchText)) {
                    tableRows[i].style.display = '';
                } else {
                    tableRows[i].style.display = 'none';
                }
            }
        });

        const ceklis = document.getElementById("check");
        const box = document.querySelectorAll(".frs");
        ceklis.addEventListener('click', function() {


            // Cek apakah semua checkbox sudah dicentang
            const allChecked = Array.from(box).every(checkbox => checkbox.checked);
            
            // Toggle semua checkbox
            box.forEach(checkbox => {
                checkbox.checked = !allChecked; // Jika semua sudah dicentang, hapus centang, sebaliknya centang semua
            });

            // Perbarui tombol berdasarkan status checkbox
            if (allChecked) {
                ceklis.classList.remove('bg-warning'); // Hapus kelas bg-warning
                ceklis.classList.add('bg-success'); // Tambahkan kelas bg-warning
                ceklis.textContent = 'Pilih Semua'; // Ubah teks tombol
            } else {
                ceklis.classList.add('bg-warning'); // Tambahkan kelas bg-warning
                ceklis.classList.remove('bg-success'); // Hapus kelas bg-warning
                ceklis.textContent = 'Batal'; // Ubah teks tombol
            }
        });
    </script>
@endsection
