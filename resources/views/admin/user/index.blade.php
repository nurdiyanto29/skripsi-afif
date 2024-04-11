@extends('layout.admin')

@section('content')
    @php
        $urlPath = request()->path(); // Mendapatkan path URL saat ini
        $segments = explode('/', $urlPath); // Memecah path menjadi segmen berdasarkan '/'.
        $title = isset($segments[1]) ? $segments[1] : '';
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data {{ str_replace('_', ' ', Str::title($title)) }}</h3>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#user"
                            type="button">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th style="width: 20px">No</th>
                                <th>Nama </th>
                                <th>Email </th>
                                <th>Role </th>
                                <th>Status </th>
                                <th style="width: 20px"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x = 1;
                                $columnCount = count($data->first() ? $data->first()->toArray() : []);
                            @endphp
                            @foreach ($data as $val)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->role }}</td>
                                    <td>{{ $val->status }}</td>
                                    <td style="text-align: center"> <a href="#" class="nav-link has-dropdown"
                                            data-toggle="dropdown"><i class="fa fa-ellipsis-h "
                                                style="color: #777778"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/admin/user/edit?_i={{$val->id}}" class="nav-link" >Edit</a></li>
                                            <li><a href="#" class="nav-link" data-toggle="modal"
                                                    data-target="#hapusModal{{ $val->id }}">Delete</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="JenisTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JenisTitle">Tambah {{ str_replace('_', ' ', Str::title($title)) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/' . $title . '/store') }}" name="form" id="form" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label style="color: #6c757d">Nama</label>
                            <input type="text" maxlength="20" class="form-control" id="name"
                                name="name">
                        </div>
                        <div class="form-group">
                            <label style="color: #6c757d">Email</label>
                            <input type="email" maxlength="50" class="form-control" id="email"
                                name="email">
                        </div>
                        <div class="form-group">
                            <label style="color: #6c757d">Role</label>
                            <select class="form-control" name="role">
                                <option selected>--Silahkan Pilih--</option>
                                    <option value="operator">Operator </option>
                                    <option value="pemilik">Pemilik </option>
                                 
                            </select>
                        </div>
                        <div class="modal-footer bg-whitesmoke" style="margin-right:-25px">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data as $item)
        <div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="hapusModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data ini: {{ $item->id }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.user.delete', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
