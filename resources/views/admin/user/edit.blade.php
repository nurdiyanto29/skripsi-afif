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
            <h5 class="mt-4 mb-2">Edit User</h5>
            <form action="{{ url('admin/user/update') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label style="color: #6c757d">Nama</label>
                    <input type="text" maxlength="20" class="form-control" id="name" name="name"
                        required value="{{$data->name}}">
                </div>
                <div class="form-group">
                    <label style="color: #6c757d">Email</label>
                    <input type="text" maxlength="20" class="form-control" id="email" name="email"
                        required value="{{$data->email}}">
                </div>
        
                <div class="form-group">
                    <label>Jenis Atribut</label>
                    <select class="form-control" name="role" required>
                        <option selected>--Silahkan Pilih--</option>
                        <option value="pemilik" {{$data->role == 'pemilik' ? 'selected' : ''}}>Pemilik</option>
                        <option value="operator" {{$data->role == 'operator' ? 'selected' : ''}}>Operator</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="" autocomplete = "new-password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                </div>

                <p>**Kosongi password apabila tidak ingin mengubah</p>

                <button type="submit" name="_i" value="{{$data->id}}" class="btn btn-primary">Simpan</button>

            </form>
        </div>
    @endsection

    @push('js')
       
    @endpush
