@extends('frontend.main')

@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Nikmati Liburan Bersama Kami</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Profesional, Mudah, dan Murah</p>
                    <form action="{{ url('destinasi') }}" method="GET" class="position-relative w-75 mx-auto animated slideInDown">
                        <input name="keyword" class="form-control border-0 rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Cth: Indrayanti">
                        <button type="submit" class="btn btn-primary rounded-pill py-2 px-4 position-absolute top-0 end-0 me-2" style="margin-top: 7px;">Search</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>


    <!-- Destination Start -->
    @if ($objek->count() == 4)
        <div class="container-xxl py-5 destination">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Destinasi</h6>
                    <h1 class="mb-5">Destinasi Populer</h1>
                </div>
                <div class="row g-3">
                    <div class="col-lg-7 col-md-6">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                <a class="position-relative d-block overflow-hidden" href="">
                                    <img class="img-fluid"
                                        src="{{ files_folder($objek[0]->foto_objek->created_at, $objek[0]->foto_objek->disk_name) }}"
                                        alt="">
                                    <div
                                        class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                        {{ $objek[0]->nama }}</div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                                <a class="position-relative d-block overflow-hidden" href="">
                                    <img class="img-fluid"src="{{ files_folder($objek[1]->foto_objek->created_at, $objek[1]->foto_objek->disk_name) }}"
                                        alt="">
                                    <div
                                        class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                        {{ $objek[1]->nama ?? '' }}</div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                <a class="position-relative d-block overflow-hidden" href="">
                                    <img class="img-fluid"
                                        src="{{ files_folder($objek[2]->foto_objek->created_at, $objek[2]->foto_objek->disk_name) }}"
                                        alt="">
                                    <div
                                        class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                        {{ $objek[2]->nama ?? '' }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                        <a class="position-relative d-block h-100 overflow-hidden" href="">
                            <img class="img-fluid position-absolute w-100 h-100"
                                src="{{ files_folder($objek[3]->foto_objek->created_at, $objek[3]->foto_objek->disk_name) }}"
                                alt="" style="object-fit: cover;">
                            <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                {{ $objek[3]->nama ?? '' }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Destination Start -->


    <!-- Package Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Objek</h6>
                <h1 class="mb-5">Objek Wisata</h1>
            </div>
            <style>
                .package-item .overflow-hidden {
                    height: 200px;
                    /* Atur tinggi gambar sesuai kebutuhan Anda */
                    overflow: hidden;
                }

                .package-item .overflow-hidden img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            </style>

            <div class="row g-4 justify-content-center">
                @foreach ($objek as $item)
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="package-item">
                            <div class="overflow-hidden">
                                <img class="img-fluid"
                                    src="{{ files_folder($item->foto_objek->created_at, $item->foto_objek->disk_name) }}"
                                    alt="">
                            </div>
                            <div class="d-flex border-bottom">
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-map-marker-alt text-primary me-2"></i>{{ $item->nama }}</small>
                                <small class="flex-fill text-center border-end py-2"><i
                                        class="fa fa-calendar-alt text-primary me-2"></i>{{ nominal($item->biaya_masuk) }}/
                                    Orang</small>
                            </div>
                            <div class="text-center p3">
                                <p>{!! sederhana($item->deskripsi, 150) !!}</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="{{url('destinasi_detail?objek_id='.$item->id)}}" class="btn btn-sm btn-primary px-3 border-end"
                                        style="border-radius: 30px">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- Package End -->

    <!-- Process Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Proses</h6>
                <h1 class="mb-5">3 Langkah Menuju Petualangan</h1>
            </div>
            <div class="row gy-5 gx-4 justify-content-center">
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-globe fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Temukan Wisata Menggoda</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Jelajahi dunia dengan pilihan destinasi wisata yang tak terlupakan, dan jadikan setiap momen berharga.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-dollar-sign fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Lakukan Transaksi dengan Mudah</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Nikmati kemudahan dalam melakukan pembayaran, karena setiap perjalanan berharga layaknya investasi pada dirimu sendiri.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-plane fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Mulai Petualangan Tak Terlupakan</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Langit biru menantimu untuk menjelajah, mulailah petualanganmu dan rangkullah kenangan indah sepanjang perjalanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Process Start -->


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
    <!-- Team End -->
@endsection
