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
                    <div class="form-group col-lg-4">
                        <label>Atraksi</label>
                        <input type="text" class="form-control" id="atraksi" name="atraksi" value="{{ $data->atraksi }}"
                            required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Biaya Masuk</label>
                        <input type="text" class="form-control" id="biaya_masuk" name="biaya_masuk" value="{{ $data->biaya_masuk }}"
                            required>
                    </div>
                 
                
                </div>
                <!-- /.card-body -->
                <button type="submit" name="_i" value="{{ $data->id }}" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Script untuk menghapus foto
    document.getElementById('deletePhoto').addEventListener('click', function() {
        document.getElementById('currentPhoto').remove();
        document.getElementById('foto').value = '';
    });

    // Script untuk mengganti foto saat pengguna memilih file baru
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.maxHeight = '200px';

            const currentPhoto = document.getElementById('currentPhoto');
            currentPhoto.innerHTML = '';
            currentPhoto.appendChild(img);
        };

        reader.readAsDataURL(file);
    });
</script>
@endpush
