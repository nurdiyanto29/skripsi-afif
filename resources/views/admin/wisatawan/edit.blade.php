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
            <form action="{{ url('admin/wisatawan/update') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}"
                            required>
                    </div>
                 
                    <div class="form-group col-lg-4">
                        <label>NO Tlp</label>
                        <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ $data->no_tlp }}"
                            required>
                    </div>
                 
                    <div class="form-group col-lg-4">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}"
                            required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $data->alamat }}"
                            required>
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


               
                </div>
                {{-- {{ dd(files_folder($data->foto_wisatawan->created_at, $data->foto_wisatawan->disk_name)) }} --}}

                <!-- /.card-body -->
                <button type="submit" name="_i" value="{{ $data->id }}" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
