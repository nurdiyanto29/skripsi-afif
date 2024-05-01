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
            <form action="{{ url('admin/objek_wisata/update') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}"
                            required>
                    </div>
                    <div class="form-group col-lg-8">
                        <label>Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $data->lokasi }}"
                            required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="atraksi">Atraksi</label>
                        <textarea class="form-control" id="atraksi" name="atraksi" rows="4" required>{{$data->atraksi }}</textarea>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $data->deskripsi }}</textarea>
                    </div>
                    

                    <div class="form-group col-lg-4">
                        <label>Biaya Masuk</label>
                        <input type="text" class="form-control" id="biaya_masuk" name="biaya_masuk" value="{{ $data->biaya_masuk }}"
                            required>
                    </div>

                    <div class="form-group col-12">
                        <label style="color: #6c757d">Foto</label>
                        <div class="input-images">
                        </div>
                    </div>
                 
                
                </div>
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
            $('.input-images').imageUploader({
                preloaded: [{
                    src: '<?php echo files_folder($data->foto_objek->created_at, $data->foto_objek->disk_name); ?>', // Ganti ini dengan pemanggilan fungsi files_folder yang sesuai
                }],
                extensions: [".jpg", ".jpeg", ".png", ".gif", ".svg"],
                imagesInputName: "foto_objek",
                maxFiles: 1,
                maxFileSize: 5 * 1024 * 1024, // Ukuran maksimum file dalam bytes (di sini, 5 MB)
                minWidth: 800, // Lebar maksimum gambar dalam piksel
                maxHeight: 600, // Tinggi maksimum gambar dalam piksel
            });
        });
    </script>
@endpush

