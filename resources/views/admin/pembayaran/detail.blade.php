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
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <tr>
                            <td rowspan="7" style="text-align: center">
                                <img class="img-fluid" style="width: 300px"
                                    src="{{ files_folder($data->foto_pembayaran->created_at, $data->foto_pembayaran->disk_name) }}"
                                    alt="">
                            </td>
                        </tr>
                        <tr>
                            <td>Pesanan</td>
                            <td>TRX00000{{ $data->pesanan_id }}</td>
                        </tr>
                        <tr>
                            <td>Wisatawan</td>
                            <td>{{ $data->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Bayar</td>
                            <td>{{ tgl($data->tgl_pembayaran) }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $data->status }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Pembayaran</td>
                            <td>{{ nominal($data->jumlah_pembayaran) }}</td>
                        </tr>
                        <tr>
                            <td> <!-- Tombol Konfirmasi -->
                                <!-- Tombol Tolak -->
                            </td>
                            <td> 
                                @if ($data->status == 'dibayar')     
                                <form action="{{ url('admin/pembayaran/konfirmasi') }}" method="post" class="float-left mr-1">
                                    @csrf
                                    <input type="hidden" name="pembayaran_id" value="{{$data->id}}">
                                    <input type="hidden" name="flag" value="dikonfirmasi">
                                    <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                </form>
                                <form action="{{ url('admin/pembayaran/konfirmasi') }}" method="post" class="float-right">
                                    @csrf
                                    <input type="hidden" name="flag" value="tolak">
                                    <input type="hidden" name="pembayaran_id" value="{{$data->id}}">

                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                                @endif
                            </td>
                        </tr>

                    </table>



                </div>
            </div>
        </div>
    </div>
@endsection
