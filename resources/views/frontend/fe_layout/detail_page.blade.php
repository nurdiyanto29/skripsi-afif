@extends('frontend.fe_layout.with_sidebar')

@section('item')
    @php
        $judul = $data->nama ?? $data->judul;
        $foto = $data->foto ?? null;
        $item_list = $item_list ?? [];
        
    @endphp

    @if ($foto)
        <div class="main-img">
            <img class="img-fluid" src="{{ image($foto, true) }}" alt="" width="100%">
        </div>
    @endif

    <div class="details-content ">
        <h3 style="margin:20px 0px">{{ $judul }}</h3>
        @if ($show_date)
            <p>{{ date('d F Y', strtotime($data->created_at)) }}</p>
        @endif
        @if ($data->whatsapp ?? null)
            <a href="https://wa.me/{{ $data->whatsapp }}" target="_blank">
                <span class="fa fa-lg fa-whatsapp text-success"></span>
                {{ $data->whatsapp }}
            </a>
        @endif

        @foreach ($item_list as $k => $lt)
            <p>{{ $k }} : {{ $data->{$lt} }}</p>
        @endforeach
        {!! $data->deskripsi ?? $data->keterangan !!}
    </div>

    @if ($data->file)
        <div class="mt-4">
            <b> Lampiran : </b><a href="{{ $base_url . "/download/{$data->id}" }}" target="_blank">&nbsp;&nbsp;<i
                    class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;<u><b>Download PDF</b></u></a>
        </div>
    @endif
@endsection
