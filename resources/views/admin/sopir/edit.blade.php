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


    <link rel="stylesheet" href="{{ asset('image-uploader-master/dist/image-uploader.min.css') }}">
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
            <form action="{{ url('admin/sopir/update') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}"
                            required>
                    </div>
                    <div class="form-group col-lg-8">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ $data->tanggal_lahir }}" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" {{ old('jenis_kelamin') == '' ? 'selected' : '' }} disabled>Pilih jenis
                                kelamin</option>
                            <option value="L" {{ $data->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $data->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>


                    <div class="form-group col-lg-12">
                        <label style="color: #6c757d">Foto</label>
                        <div class="input-images">
                        </div>
                    </div>

                </div>
                {{-- {{ dd(files_folder($data->foto_sopir->created_at, $data->foto_sopir->disk_name)) }} --}}

                <!-- /.card-body -->
                <button type="submit" name="_i" value="{{ $data->id }}" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" href="{{ asset('image-uploader-master/dist/image-uploader.min.css') }}">
    <script src="{{ asset('image-uploader-master/dist/image-uploader.min.js') }}"></script>
    <script>
       $(document).ready(function() {
    var fotoSopirSrc = '<?php echo $data->foto_sopir ? files_folder($data->foto_sopir->created_at, $data->foto_sopir->disk_name) : null; ?>';

    $('.input-images').imageUploader({
        preloaded: [{
            src: fotoSopirSrc,
        }],
        extensions: [".jpg", ".jpeg", ".png", ".gif", ".svg"],
        imagesInputName: "foto_sopir",
        maxFiles: 1,
        maxFileSize: 5 * 1024 * 1024, // Ukuran maksimum file dalam bytes (di sini, 5 MB)
        minWidth: 800, // Lebar maksimum gambar dalam piksel
        maxHeight: 600, // Tinggi maksimum gambar dalam piksel
    });
});

    </script>
@endpush
