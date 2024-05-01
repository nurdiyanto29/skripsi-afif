@extends('frontend.main')

@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Objek WIsata</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Objek WIsata</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

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
@endsection
