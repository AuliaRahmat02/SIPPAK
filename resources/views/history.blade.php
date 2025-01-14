@extends('layout.nav')
@section('isi')
    <div class="mx-auto w[80%] flex justify-center">
        <div class="overflow-x-auto odd:bg-white even:bg-slate-50 outline-1 min-w-[1200px]">
            <div class="overflow-x-auto">
                <table class="table table-xs">
                    <thead>
                        <tr>
                            <th></th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataHistory as $data)
                            <tr>
                                <th></th>
                                <th>{{ $data->NIP }}</th>
                                <td>{{ $data->Nama }}</td>
                                <td>{{ $data->Keterangan }}</td>
                                <td>{{ $data->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
