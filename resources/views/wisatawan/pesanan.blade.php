@extends('frontend.main')

@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Pesanan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Pesanan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">

            <div class="row g-5 align-items-center">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Transaksi</th>
                            <th scope="col">Tanggal Keberangkatan</th>
                            <th scope="col">Jam</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Jml Orang</th>
                            <th scope="col">Travel</th>
                            <th scope="col">Sopir</th>
                            <th scope="col">Cetak Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $x= 1;
                        @endphp
                        @foreach ($pesanan as $item)
                        <tr>
                            <th scope="row">{{$x++}}</th>
                            <td>
                                <a href="{{ url('pembayaran?pesanan_id='.$item->id) }}">{{ 'TRX00000'.$item->id }}</a>
                            </td>
                            <td>{{tgl($item->tanggal)}}</td>
                            <td>{{($item->jam)}}</td>
                            <td>{{($item->status)}}</td>
                            <td>{{($item->jumlah_wisatawan)}}</td>
                            <td>{{($item->travel->nama ?? '')}}</td>
                            <td>{{($item->travel->sopir->nama?? '')}}</td>
                            <td>
                                @if ($item->status == 'disetujui' || $item->status == 'selesai')
                                    <a href="etiket?pesanan_id={{$item->id}}">E-Tiket</a>
                                @endif
                            </td>
                           
                        </tr>
                        @endforeach
                      
                    </tbody>
                </table>
            </div>



        </div>
    </div>
    <!-- Booking End -->
@endsection
