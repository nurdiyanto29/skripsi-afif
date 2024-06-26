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
                            onclick="window.location='{{ url('/admin/pesanan/create') }}'">
                            <i class="fas fa-plus"></i> Tambah
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        @php
                            $customLabels = [
                                'user_id' => 'Wisatawan', // Menyimpan perubahan dari 'wisatawan' menjadi 'user'
                                'id' => 'Transaksi', // Menyimpan perubahan dari 'wisatawan' menjadi 'user'
                                // Tambahkan custom labeling untuk kolom lain jika diperlukan
                            ];
                        @endphp

                        <thead>
                            <tr style="text-align: center">
                                <th style="width: 20px">No</th>
                                @foreach ($componen as $cn)
                                    @php
                                        $customLabel = array_key_exists($cn, $customLabels)
                                            ? $customLabels[$cn]
                                            : ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $cn)));
                                    @endphp
                                    <th>{{ $customLabel }}</th>
                                @endforeach
                                <th style="width: 20px"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $x = 1;
                                $customFormats = [
                                    'id' => fn($value) => 'TRX00000' . $value,
                                    'biaya_masuk' => fn($value) => nominal($value),
                                    'tanggal' => fn($value) => tgl($value),
                                    // 'user_id' => fn($value) => $value->user->name ?? '',
                                    // 'travel_id' => fn($value) => ($value->travel->nama ?? ''),
                                ];
                            @endphp
                            @foreach ($data as $val)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    @foreach ($componen as $cn)
                                        <td>
                                            @if (array_key_exists($cn, $customFormats))
                                                {{ $customFormats[$cn]($val->$cn) }}
                                            @elseif ($cn == 'user_id')
                                                {{ $val->user->name ?? '' }}
                                            @elseif ($cn == 'travel_id')
                                                {{ $val->travel->nama ?? '' }}
                                            @else
                                                {{ $val->$cn }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td style="text-align: center">
                                        <div class="nav-link has-dropdown" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h" style="color: #777778"></i>
                                        </div>
                                        <ul class="dropdown-menu">
                                            @if ($val->status == 'disetujui')
                                                <li><a href="/admin/pesanan/selesaikan?_i={{ $val->id }}"
                                                        class="nav-link">Konfirmasi Selesai</a></li>
                                            @endif

                                            <li><a href="/admin/pesanan/edit?_i={{ $val->id }}"
                                                    class="nav-link">Edit</a></li>
                                            <li><a href="#" class="nav-link delete-data"
                                                    data-id="{{ $val->id }}" data-toggle="modal"
                                                    data-target="#deleteModal">Delete</a></li>
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
                    <form action="{{ route('admin.pesanan.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <p> Apakah Anda yakin ingin menghapus data ?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" style="width: 50px" class="btn btn-secondary">Ya</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '.delete-data', function() {
            let id = $(this).attr('data-id');
            $('#id').val(id);
        });
    </script>
@endpush
