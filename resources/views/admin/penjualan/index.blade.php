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
                        <button class="btn btn-primary btn-sm float-right" type="button"
                            onclick="window.location='{{ url('/admin/penjualan/create') }}'">
                            <i class="fas fa-plus"></i> Tambah
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th style="width: 20px">No</th>
                                <th>No. Penjualan </th>
                                <th> Tgl Penjualan</th>
                                <th>Detail Produk</th>
                                <th>Total Harga</th>
                                <th>User</th>
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
                                    <td>{{ $val->no_penjualan }}</td>
                                    <td>{{ tgl($val->tanggal) }}</td>

                                    <td>
                                        <ul>
                                            @foreach ($val->penjualan_detail as $detail)
                                                <li>
                                                    Produk : {{ $detail->produk_id }} ({{ $detail->produk->nama_produk  ?? 0}}) |
                                                    Harga:( Rp {{ nominal($detail->produk->harga_jual ?? 0) }} x {{ $detail->jumlah }} )
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td style="text-align: right">
                                        <ul>
                                            @foreach ($val->penjualan_detail as $detail)
                                                <li style="list-style: none">
                                                    Rp {{ nominal(($detail->produk->harga_jual  ?? 0) * $detail->jumlah) }}
                                                </li>
                                            @endforeach
                                            @php
                                                $totalPenjualan = DB::table('penjualan_detail')
                                                    ->join('produk', 'penjualan_detail.produk_id', '=', 'produk.produk_id')
                                                    ->where('penjualan_detail.no_penjualan', $val->no_penjualan) // Ganti ini sesuai dengan kunci penjualan yang sesuai
                                                    ->sum(DB::raw('penjualan_detail.jumlah * produk.harga_jual'));
                                            @endphp
                                            <hr>
                                            <li style="color: red; list-style:none">
                                                Total : Rp {{ nominal($totalPenjualan) }}
                                            </li>
                                        </ul>
                                    </td>
                                    <td>{{ $val->user->name }}</td>
                                    <td style="text-align: center"> <a href="#" class="nav-link has-dropdown"
                                            data-toggle="dropdown"><i class="fa fa-ellipsis-h "
                                                style="color: #777778"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/admin/penjualan/edit?_i={{$val->no_penjualan}}" class="nav-link">Edit</a></li>
                                            <li> <a href="#" id="delete-data" data-id={{ $val->no_penjualan }}
                                                class="nav-link" data-toggle="modal"
                                                data-target="#deleteModal">Delete</a></li>
                                        </a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-size: 20px" class="modal-title" id="exampleModalCenterTitle"><i
                                class="fas fa-info-circle"></i><span></span> Konformasi Hapus!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.penjualan.delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <p> Apakah Anda yakin ingin menghapus data penjualan ? <br> <span style="color: red">Termasuk akan mengembalikan stok produk yang telah terjual</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="width: 50px" class="btn btn-secondary">Ya</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '#delete-data', function() {
            let id = $(this).attr('data-id');
            $('#id').val(id);
        });
    </script>
@endpush

