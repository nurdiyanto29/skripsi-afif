@extends('layout.admin')

@push('css')
    <style>
        .mt-4,
        .my-4 {
            margin-top: 1rem !important;
        }

        .alert {
            position: relative;
            padding: .5rem .5rem;
            padding-right: 0.5rem;
            margin-bottom: 0rem;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            border-radius: .25rem;
        }

        dl,
        ol,
        ul {
            margin-top: 0;
            margin-bottom: 0rem;
        }
    </style>
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"> --}}

@endpush
@section('content')
    <div class="wire-form">
        @php
            // dikumpulkan dan ditambah # didepannya, untuk dijadikan id di js
            $_multiple = $_select = [];
        @endphp
        <div wire:loading class="wire-loading text-warning">
            <span class="fa fa-spin fa-spinner "></span> Sedang memproses...
        </div>
        'tanggal',
        'jam',
        'user_id',
        'jumlah_wisatawan',
        'mobil_id',
        <div class="col-8">
            <h5 class="mt-4 mb-2">Tambah Data</h5>
            <form action="{{ url('admin/pesanan/store') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label> {{ ucwords(str_replace('_', ' ', 'tanggal')) }}</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ old('tanggal') }}" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label> {{ ucwords(str_replace('_', ' ', 'jam')) }}</label>
                        <input type="text" class="form-control" id="jam" name="jam"
                            value="{{ old('jam') }}" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label> Wisatawan</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id') }}"
                            required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label> {{ ucwords(str_replace('_', ' ', 'jumlah_wisatawan')) }}</label>
                        <input type="text" class="form-control" id="jumlah_wisatawan" name="jumlah_wisatawan"
                            value="{{ old('jumlah_wisatawan') }}" required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label> {{ ucwords(str_replace('_', ' ', 'Travel')) }}</label>
                        <input type="text" class="form-control" id="travel_id" name="travel_id"
                            value="{{ old('travel_id') }}" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Objek Wisata</label>
                        <select class="form-control select2" id="objek_wisata_ids" name="objek_wisata_ids[]"  multiple="multiple" required>
                            <option value="" disabled>Pilih Objek Wisata</option>
                            @foreach ($objek as $val)
                                <option value="{{ $val->id }}" {{ in_array($val->id, (array)old('objek_wisata_ids')) ? 'selected' : '' }}>
                                    {{ $val->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <!-- /.card-body -->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#objek_wisata_ids').select2({
            placeholder: 'Pilih Objek Wisata',
            allowClear: true
        });
    });
</script>

@endpush
