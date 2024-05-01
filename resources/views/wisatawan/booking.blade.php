@extends('frontend.main')

@section('content')
<div class="container-fluid bg-primary py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-3 text-white animated slideInDown">Booking</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

  <!-- Team Start -->
  <div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Travel</h6>
            <h1 class="mb-5">Pilihan Travel</h1>
        </div>
        <div class="row g-4">

            @foreach ($travel as $item)
                <!-- resources/views/team-item.blade.php -->

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="overflow-hidden" style="text-align:center">
                            <img class="img-fluid"
                                src="{{ files_folder($item->foto_travel->created_at, $item->foto_travel->disk_name) }}"
                                alt="">
                        </div>
                        <div class="text-center p-0">
                            <h5 class="mb-0">{{ $item->nama }}</h5>
                            <p class="mb-0">Jenis Mobil - {{ $item->jenis_mobil }}</p>
                            <p class="mb-0">Tranmisi - {{ $item->tranmisi }}</p>
                            <p class="mb-0">Nama - {{ $item->nama }}</p>
                            <p class="mb-0">Kap Maximal - {{ $item->jml_kursi }} Orang</p>
                            <p class="mb-0">Tahun Mobil - {{ $item->tahun_mobil }}</p>
                            <p class="mb-0">Harga Sewa - {{ nominal($item->harga) }}</p>
                            <p class="mb-0">Durasi Sewa - {{ $item->durasi_sewa }} Jam</p>

                            <a class="btn btn-outline-light py-3 px-5 mt-2"  href="pesan_travel?_travel_id={{$item->id}} ">Pesan</a>

                        </div>

                    </div>
                </div>
            @endforeach
            @foreach ($travel_dipesan as $item)
            <!-- resources/views/team-item.blade.php -->

            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item">
                    <div class="overflow-hidden" style="text-align:center">
                        <img class="img-fluid"
                            src="{{ files_folder($item->foto_travel->created_at, $item->foto_travel->disk_name) }}"
                            alt="">
                    </div>
                    <div class="text-center p-0">
                        <h5 class="mb-0">{{ $item->nama }}</h5>
                        <p class="mb-0">Jenis Mobil - {{ $item->jenis_mobil }}</p>
                        <p class="mb-0">Tranmisi - {{ $item->tranmisi }}</p>
                        <p class="mb-0">Nama - {{ $item->nama }}</p>
                        <p class="mb-0">Kap Maximal - {{ $item->jml_kursi }} Orang</p>
                        <p class="mb-0">Tahun Mobil - {{ $item->tahun_mobil }}</p>
                        <p class="mb-0">Harga Sewa - {{ nominal($item->harga) }}</p>
                        <p class="mb-0">Durasi Sewa - {{ $item->durasi_sewa }} Jam</p>
                        <p class="btn-secondary py-3 px-5 mt-2">Terbooking</p>
                    </div>

                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
