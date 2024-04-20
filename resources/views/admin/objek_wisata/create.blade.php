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
        <div class="col-8">
            <h5 class="mt-4 mb-2">Tambah Data</h5>
            <form action="{{ url('admin/objek_wisata/store') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group col-lg-8">
                        <label>Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="{{ old('lokasi') }}" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="atraksi">Atraksi</label>
                        <textarea class="form-control" id="atraksi" name="atraksi" rows="4" required>{{ old('atraksi') }}</textarea>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                    </div>
                    
                    <div class="form-group col-lg-4">
                        <label>Biaya Masuk</label>
                        <input type="number" class="form-control" id="biaya_masuk" name="biaya_masuk"
                            value="{{ old('biaya_masuk') }}" required>
                    </div>
              
                    
                    
                {{-- <div class="form-group col-lg-8">
                    <label>Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar"
                        value="{{ old('gambar') }}">
                </div> --}}
            </div>
                <!-- /.card-body -->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection