<?php 
    function cc($s)
    {
        return ucwords(strtolower($s));
    }

    // function tanggal($string)
    // {
    //     $b = Carbon::parse($string)->translatedFormat('j F Y');
    //     return $b;
    // }
?>

@extends('layout.nav')
@section('isi')
    <div class="mx-auto  w[80%] flex justify-center">
        <div class="overflow-x-auto odd:bg-white even:bg-slate-50 outline-1">

        </div>
    </div>
    <div class="mx-auto mt-10   w-full flex justify-center">
        <div class="overflow-auto w-[90%]  outline-1">
            <div class="flex-col w-full lg:flex-row-reverse ">
                <div class="card w-full shrink-0 shadow-md shadow-green-300 my-3 bg-base-100 p-5">
                <h1 class="text-3xl font-bold">DATA PEGAWAI</h1>
                <ul class="w-full py-6 select-none">
                    <li><span class="font-bold">NIP :</span> {{ $data->nip }}</li>
                    <li><span class="font-bold">Nama :</span> {{ $data->nama_pns }}</li>
                    <li><span class="font-bold">Tempat/Tanggal Lahir :</span>{{ $data->tmpt_lahir }} , {{ \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">Agama :</span> {{ cc($data->agama_nm) }}</li>
                    <li><span class="font-bold">Umur :</span> {{ $data->usia }} tahun</li>
                    <li><span class="font-bold">Kelamin :</span> {{ cc($data->gender_nm) }}</li>
                    <li><span class="font-bold">Alamat :</span> {{ $data->alamat }}</li>
                    <li><span class="font-bold">Status :</span> {{ cc($data->kawin_nm) }}</li>
                    <li><span class="font-bold">Status PNS :</span> {{  cc($data->status_pns_nm); }}</li>
                    <li><span class="font-bold">Jatah Cuti :</span> {{ $data->jatah_cuti }}</li>

                    <br>

                    <li><span class="font-bold">Biro :</span> {{ cc($data->opd_nm) }}</li>
                    <li><span class="font-bold">Tingkat Pendidikan :</span> {{ $data->nama_study }}</li>
                    <li><span class="font-bold">Jurusan :</span> {{ $data->jurusan }}</li>
                    <li><span class="font-bold">Gaji Pokok :</span> Rp {{ number_format($data->gapok, 0,",",".") }}</li>
                    <li><span class="font-bold">Masa Kerja :</span> {{ cc($data->masa_kerja)}}</li>
                    <li><span class="font-bold">Pangkat :</span> {{ $data->pangkat}}</li>

                    <br>

                    <li><span class="font-bold">TMT Gaji :</span> {{  \Carbon\Carbon::parse($data->tmt_gaji)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">TMT Pangkat :</span> {{  \Carbon\Carbon::parse($data->tmt_golru)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">Tanggal CPNS :</span> {{  \Carbon\Carbon::parse($data->tgl_cpns)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">TMT CPNS :</span> {{  \Carbon\Carbon::parse($data->tmt_cpns)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">Tanggal PNS :</span> {{  \Carbon\Carbon::parse($data->tgl_pns)->translatedFormat('j F Y') }}</li>
                    <li><span class="font-bold">TMT PNS :</span> {{  \Carbon\Carbon::parse($data->tmt_pns)->translatedFormat('j F Y') }}</li>

                    <br>

                    <li><span class="font-bold">SK CPNS :</span> {{ $data->sk_cpns }}</li>
                    <li><span class="font-bold">SK PNS :</span> {{ $data->sk_pns }}</li>
                </ul>

            </div>


            {{-- =====================Input bahan surat pengantar ==================================--}}
            <div class="card bg-base-100 w-full mt-8 shrink-0 flex flex-row flex-wrap shadow-md shadow-green-300">
                <div class="basis-full">
                    <h1 class="text-3xl font-bold m-7">INPUT BAHAN SURAT PENGANTAR</h1>
                </div>

                <ul class="card-body basis-1/2">
                    @foreach ($surat as $s)
                        <a class="w-full shadow-lg p-4 bg-base-200 rounded-md hover:shadow-green-300" href="/bahan/{{ $s->ID }}" target="_blank"><li>{{ $s->nama }}.pdf</li></a> 
                    @endforeach
                </ul>

                @if (!Gate::any(["kabag","admin","jft","kabiro"]))  
                    <form action="/uploadBahan" method="POST" enctype="multipart/form-data" class="card-body basis-1/2">
                        @csrf
                        
                        <div class="form-control">
                            <label class="label">
                            <span class="label-text font-bold">Bahan Pengantar Kenaikan Pangkat</span>
                            </label>
                            <input type="text" name="nip" value="{{$data->nip}}" required hidden/>
                            <input type="text" name="nama" value="{{$data->nama_pns}}" required hidden/>

                            @error('file')
                                <span class="text-red-500 pb-2">{{ $message }}</span>
                            @enderror
                            <input type="file" name="file" class="file-input file-input-bordered file-input-success file-input-sm w-full max-w-xs" required/>

                            @error('jenisSurat')
                                <span class="font-red">{{ $message }}</span>
                            @enderror
                            <select name="jenisBahan" class="select select-bordered select-success w-full max-w-xs my-3">
                                <option disabled selected>Pilih Bahan</option>
                                <option value=1>Bahan Pengantar Kenaikan Pangkat</option>
                                <option value=2>Bahan Pengantar Pensiun</option>
                                <option value=3>Bahan Pengantar Kartu Istri/Suami</option>
                                <option value=4>Bahan Pengantar Permohonan Izin Belajar</option>
                                <option value=5>Bahan Pengantar Surat Ijazah dan Pemakaian Gelar</option>
                                <option value=6>Bahan Pengantar Penghargaan Satyalencana</option>
                            </select>
                        </div>
                        <div class="form-control mt-1">
                            <button type="submit" class="w-32 btn btn-success">Submit</button>
                        </div>
                    </form>
                @endif

                
            </div>

            {{-- ======================================================================================== --}}
            <div class="card bg-base-100 w-full shrink-0 flex flex-row flex-wrap shadow-md my-8 shadow-green-300">
                {{-- PENGTINGGG --}}
                <div class="basis-full">
                    <h1 class="text-3xl font-bold m-7">Bahan Surat Cuti</h1>
                </div>

                <ul class="card-body basis-1/2">
                    @foreach ($datacuti as $c)
                    <a class="w-full shadow-lg p-4 bg-base-200 rounded-md hover:shadow-green-300" href="/files/download/{{ $c->ID }}" target="_blank"><li> {{ $c->file_name }}.pdf</li></a> 
                    @endforeach
                </ul>


                @if (!Gate::any(['Admin', "kabag","kabiro","jft"]))    
                    <form action="{{ route('uploadcuti') }}" method="POST" enctype="multipart/form-data" class="card-body basis-1/2">
                        @csrf
                        <div class="form-control">
                            <input type="text" hidden name="nip" value="{{ $data->nip }}"/>
                            <input type="text" hidden name="nama" value="{{ $data->nama_pns }}"/>
                            <label class="label">
                                <span class="font-bold label-text">Input bahan</span>
                            </label>

                            @error('file')
                                <span class="text-red-500 pb-2">{{ $message }}</span>
                            @enderror
                            <input type="file" name="file" class="w-full max-w-xs file-input file-input-bordered file-input-success file-input-sm" required/>
                        </div>

                        @error('jenisSurat')
                            <span class="text-red-500 pb-2">{{ $message }}</span>
                        @enderror
                        <select name="jenisSurat" class="select select-bordered select-success w-full max-w-xs">
                            <option disabled selected>Pilih Bahan</option>
                            <option value=1>Surat Pengantar</option>
                            <option value=2>Nota</option>
                            <option value=3>Blanko</option>
                            <option value=4>Bukti Dukung</option>
                        </select>
                        <div class="flex mt-1 form-control" style="flex-direction: row">
                            <button type="submit" class="w-32 btn btn-success">Submit</button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
