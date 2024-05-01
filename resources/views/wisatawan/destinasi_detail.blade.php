@extends('frontend.main')

@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Objek Wisata</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail Objek WIsata</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ files_folder($objek->foto_objek->created_at, $objek->foto_objek->disk_name) }}" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Objek Wisata</h6>
                    <h1 class="mb-4">{{$objek->nama}}</h1>
                    <p class="mb-0">Lokasi</p>
                    <p class="mb-4">{{$objek->lokasi}}</p>
                    <p class="mb-0">Keterangan</p>
                    <p class="mb-4">{!!$objek->deskripsi!!}</p>
                    <p class="mb-0">Atraksi</p>
                    <p class="mb-4">{!!$objek->atraksi!!}</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Biaya Masuk Per Orang {{nominal($objek->biaya_masuk)}}</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
