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
            <form action="{{ url('admin/travel/store') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'jenis_mobil')) }}</label>
                        <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil"
                            value="{{ old('jenis_mobil') }}" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'tranmisi')) }}</label>
                        <input type="text" class="form-control" id="tranmisi" name="tranmisi"
                            value="{{ old('tranmisi') }}" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'nama')) }}</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'jml_kursi')) }}</label>
                        <input type="text" class="form-control" id="jml_kursi" name="jml_kursi"
                            value="{{ old('jml_kursi') }}" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'tahun_mobil')) }}</label>
                        <input type="number" class="form-control" id="tahun_mobil" name="tahun_mobil" maxlength="4" value="2024" max="{{ date('Y') }}" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'harga')) }}</label>
                        <input type="number" class="form-control" id="harga" name="harga"
                            value="{{ old('harga') }}" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label> {{ ucwords(str_replace('_', ' ', 'durasi_sewa (jam)')) }}</label>
                        <input type="text" class="form-control" id="durasi_sewa" name="durasi_sewa"
                            value="{{ old('durasi_sewa') }}" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="sopir">Sopir</label>
                        <select class="form-control" id="sopir_id" name="sopir_id" required>
                            <option value="" {{ old('sopir_id') == '' ? 'selected' : '' }} disabled>Pilih Sopir
                            </option>
                            @foreach ($sopir as $val)
                                <option value="{{ $val->id }}" {{ old('sopir_id') == $val->id ? 'selected' : '' }}>
                                    {{ $val->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label style="color: #6c757d">Foto</label>
                        <div class="input-images">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection


@push('js')
<link rel="stylesheet" href="{{ asset('image-uploader-master/dist/image-uploader.min.css') }}">
    <script src="{{ asset('image-uploader-master/dist/image-uploader.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.input-images').imageUploader({
                extensions: [".jpg", ".jpeg", ".png", ".gif", ".svg"],
                imagesInputName: "foto_travel",
                maxFiles: 1,
                maxFileSize: 5 * 1024 * 1024, // Ukuran maksimum file dalam bytes (di sini, 5 MB)
                minWidth: 800, // Lebar maksimum gambar dalam piksel
                maxHeight: 600 // Tinggi maksimum gambar dalam piksel
            });
        });
    </script>
@endpush