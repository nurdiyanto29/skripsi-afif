@extends('frontend.fe_layout.main')

@section('content')

    @include('frontend.fe_layout._banner')

    
    <section class="post-content-area events-list-area section-gap2 event-page-lists">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-12 posts-list">
                    
                    @if (count($data))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    {{-- <tr>
                                        <th rowspan="2" class="align-middle" width="50">No</th>
                                        <th rowspan="2" class="align-middle">Nama</th>
                                        <th rowspan="2" class="align-middle">Alamat</th>
                                        <th colspan="3" class="text-center">SPPT</th>                                        
                                        <th rowspan="2" class="align-middle">Bagan</th>
                                    </tr>
                                    <tr>
                                            
                                        <th >No. SPPT</th>
                                        <th >Jumlah. SPPT</th>
                                        <th >File</th>

                                    </tr> --}}


                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. SPPT</th>
                                        <th>Jumlah</th>
                                        <th>File</th>
                                        <th>Bagan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->nomor_sppt }}</td>
                                            <td>{{ $item->jumlah_sppt }}</td>
                                            <td>
                                                @if (file_exists($item->file_sppt))
                                                    <a href="{{ "$base_url/download/sppt/$item->id" }}" target="_blank" rel="File SPPT"><i class="fa fa-file-pdf-o"></i> Download </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (file_exists($item->file_bagan))
                                                <a href="{{ "$base_url/download/bagan/$item->id" }}" target="_blank" rel="File SPPT"><i class="fa fa-file-pdf-o"></i> Download </a>
                                                @endif
                                            </td>
                                            
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div> {{ $data->links() }} </div>
                    @else
                        <div class="alert alert-info">Belum Ada Data</div>
                    @endif
                    
                </div>                

            </div>
        </div>
    </section>
    
@endsection
