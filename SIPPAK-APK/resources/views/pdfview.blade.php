@extends('layout.nav')

@section('isi')
    <div >
        <div>

            <embed src="{{ $data->id) }}" height="900" width="100%" type="application/pdf">

        </div>
    </div>
@endsection
