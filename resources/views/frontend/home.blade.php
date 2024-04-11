@extends('frontend.fe_layout.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <style>
        .fc {
            font-size: 0.8em
        }

        .fc .fc-toolbar-title {
            font-size: 1.2em
        }

        .fc-h-event {
            cursor: pointer;
        }

        .fc table {
            line-height: 0.8
        }

        .fc-col-header-cell.fc-day-sun,
        {
        background-color: #f48c8c;
        }

        .fc .fc-day-sun {
            color: #e63636
        }

        .fc .fc-day-today {
            font-weight: 600;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(40, 184, 255, 0.15)
        }

        .banner-area {
            background-image: url('{{ asset($_setting['img_header']) }}')
        }

        .cta-one-area {
            background: url('{{ asset('img/bawah.png') }}') center !important;
            background-size: auto;
            background-size: cover;
            text-align: center;
            color: #fff;
        }

        .widget-wrap {
            background: #fafaff;
            padding: 0px 0px;
            border: 0px solid #eee;
        }

        .widget-wrap .single-sidebar-widget {
            margin-left: 20px;
            margin-right: 20px;
            padding-bottom: 0px;
            border-bottom: 1px solid #eee;
        }

        .owl-carousel .owl-stage-outer {
            position: relative;
            overflow: hidden;
            -webkit-transform: translate3d(0px, 0px, 0px);
            vertical-align: middle;
            padding-top: 25px;
        }

        .single-popular-carusel .details h4 {
            margin-bottom: 2px;
            margin-top: 5px
        }

        #calendar {
            width: 100%;
            /* Ganti angka ini dengan lebar yang Anda inginkan */
            height: 265px;
            /* Ganti angka ini dengan tinggi yang Anda inginkan */
            /* Tambahkan properti CSS lainnya sesuai kebutuhan */
        }

        .banner-area .overlay-bg {
            background-color: transparent !important;
        }

        .cta-one-area .overlay-bg {
            background: rgba(4, 9, 30, 0.64);
        }


        .single-blog .wa-btn {
            /* border: 1px solid #bfa9a9; */
            /* width: 40px;
                        height: 40px; */
            /* border-radius: 20px; */
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
        }

        .single-blog a {
            color: #777;
        }

        .pamong-gap {
            padding: 40px 0 0 0;
        }
    </style>
    <!-- start banner Area -->
    <section class="banner-area relative" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row fullscreen d-flex align-items-center justify-content-between">
                <div class="banner-content col-lg-9 col-md-12">
                    <h1 style="color: #3A5197" class="text-uppercase">
                        METAFORA
                    </h1>
                    <h3 style="color: #3A5197">
                        MEDIA DATA DAN INFORMASI
                        <br>
                        KALURAHAN TRIDADI
                    </h3>
                    <br>
                    <a style="margin: 10px" href="/kotak_saran?_t=kotak_saran" class="primary-btn text-uppercase">Kotak
                        Saran</a>
                    <a style="margin: 10px" href="/kotak_saran?_t=jaring_asmara" class="primary-btn text-uppercase">Jaring
                        Asmara</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->


    {{-- Berita --}}
    <section class="popular-course-area section-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Berita Terbaru</h1>
                        <p>Daftar berita terbaru {{ $_setting['title'] }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($berita))
                    <div class="active-popular-carusel">
                        @foreach ($berita as $item)
                            @php
                                $detail_link = "/post/berita/detail/$item->id?item=$item->judul";
                                
                            @endphp
                            <div class="single-popular-carusel">
                                <div class="thumb-wrap relative">
                                    <div class="thumb relative">
                                        <a href="{{ $detail_link }}">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="{{ thumbnail($item->foto, 'thumb_', true) }}"
                                                alt="Foto">
                                        </a>
                                    </div>

                                </div>
                                <div class="details">
                                    <a href="{{ $detail_link }}">
                                        <h4 class="crop-text" style="height: 2.5em;">
                                            {{ $item->judul }}
                                        </h4>
                                    </a>
                                    <p style="height: 4em;">
                                        {!! get_substr($item->deskripsi ?? $item->keterangan, 150) !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-sm-12">
                        <div class="alert alert-info">Belum Ada Data</div>
                    </div>
                @endif

            </div>
        </div>
    </section>



    {{-- layanan --}}

    <section class="search-course-area relative box_img_url fullbg"
        style="background-image: url('{{ asset('img/ambulan.jpg') }}')">
        <div class="overlay overlay-bg"></div>
        <div class="prestasi_native">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5 col-md-6 search-course-left prestasi_top_mobile">
                    <div class="prestasi_img_for_mobile">
                        <img src="{{ asset('img/ambulan.jpg') }}" alt="" style="max-width:100%;">
                    </div>
                    <a href="/konten/layanan_kesehatan">
                        <h1 class="text-white">
                            WARNA TRIDADI </h1>
                    </a>
                    <p style="font-size:14px;  color:#fff;">
                        Warga Tridadi adalah Raja dan Anakku <br>
                        Saat ini kalurahan Tridadi memiliki layanan kesehatan unggulan yaitu satu unit mobil ambulance
                        gratis untuk masyarakat Tridadi khususnya dan Sleman pada umumnya. Jasa layanan masyarakat ini dapat
                        digunakan dengan menghubungi nomor yang tertera di bawah ini atau datang langsung kantor kalurahan
                        Tridadi <br>
                        Hubungi : 081237057962

                    </p>
                    {{-- <a href="https://mtsn7sleman.sch.id/prestasi" class="primary-btn text-uppercase">prestasi lain</a> --}}
                </div>
                <div class="col-lg-7 col-md-6 prestasi_img_for_pc" style="text-align:right;padding:50px 0;">
                    <img src="{{ asset('img/ambulan.jpg') }}" alt="" style="max-width:50%;">
                </div>
            </div>
        </div>
    </section>

    {{-- aparatur desa --}}
    <section class="popular-course-area pamong-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Aparatur Desa</h1>
                        <p>Daftar Aparatur Desa {{ $_setting['title'] }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($aparatur_desa))
                    <div class="active-popular-carusel text-center">
                        @foreach ($aparatur_desa as $item)
                            <div class="single-popular-carusel">
                                <div class="thumb-wrap relative">
                                    <a href="{{ aparatur_img($item->foto, 'thumb_', true) }}" class="img-gal">
                                        <div class="thumb relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="{{ aparatur_img($item->foto, 'thumb_', true) }}"
                                                alt="Foto">
                                        </div>
                                    </a>
                                </div>
                                <div class="details text-center">
                                    <h4>{{ $item->nama }}</h4>
                                    <h5 style="color: #777">{{ $item->jabatan }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-sm-12">
                        <div class="alert alert-info">Belum Ada Data</div>
                    </div>
                @endif

            </div>
        </div>
    </section>



    {{-- Agenda --}}

    <section class="upcoming-event-area section-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Agenda Terbaru</h1>
                        <p>Daftar agenda terbaru {{ $_setting['title'] }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($agenda))
                    <div class="col-md-8 sm-12 ">
                        <div class="active-upcoming-event-carusel">
                            @foreach ($agenda as $item)
                                @php
                                    $detail_link = "/agenda/detail/$item->id?item=$item->judul";
                                @endphp
                                <div class="single-carusel row align-items-center" style="padding-top: 30px">
                                    <div class="col-12 col-md-6 thumb">
                                        <a href="{{ $detail_link }}">
                                            <img class="img-fluid" src="{{ thumbnail($item->foto, 'thumb_', true) }}"
                                                alt="Foto">
                                        </a>
                                    </div>
                                    <div class="detials col-12 col-md-6">
                                        <p>{{ date('l, d F Y', strtotime($item->mulai)) }}</p>
                                        <a href="{{ $detail_link }}" class="crop-text-row">

                                            <h4>{{ get_substr($item->judul, 30) }}</h4>
                                        </a>
                                        <p class="crop-text" style="height:8em;">
                                            {!! get_substr($item->deskripsi ?? $item->keterangan, 150) !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4 sm-12">
                        <div class="row align-items-center">
                            <div class="widget-wrap" style="width: 100%">
                                <div class="single-sidebar-widget popular-post-widget" style="margin-top:0">
                                    <div class="popular-post-list">
                                        <div style="width: 100%" id='calendar'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @else
            <div class="col-sm-12">
                <div class="alert alert-info">Belum Ada Data</div>
            </div>
            @endif

        </div>
        </div>
    </section>


    {{-- layanan --}}

    <section class="cta-one-area relative section-gap">
        <div class="container">
            <div class="overlay overlay-bg"></div>
            <div class="row justify-content-center">
                <div class="wrap">
                    <h1 class="text-white">METAFORA TRIDADI </h1>
                    <p>
                        Media Data dan Informasi Kalurahan Tridadi Kapanewon Sleman
                    </p>
                </div>
            </div>
        </div>
    </section>



    {{-- umkm --}}

    <section class="blog-area section-gap" id="blog">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">UMKM Terbaru</h1>
                        <p>UMKM terbaru {{ $_setting['title'] }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($umkm as $item)
                    @php
                        $detail_link = "/umkm/detail/$item->id?item=$item->judul";
                        
                    @endphp


                    <div class="col-lg-3 col-md-6 single-blog mb-4">
                        <div class="thumb">
                            <a href="{{ $detail_link }}">
                                <img class="img-fluid" src="{{ thumbnail($item->foto, 'thumb_', true) }}"
                                    alt="Foto">
                            </a>
                        </div>
                        <p class="meta">{{ $item->kategori->nama ?? '' }}</p>
                        <a href="{{ $detail_link }}" style="color:black !important;">
                            <h5 class="crop-text">{{ $item->nama }}</h5>
                        </a>
                        <p class="crop-text" style="height:7em;">
                            {!! get_substr($item->deskripsi ?? $item->keterangan, 120) !!}
                        </p>
                        <div class="row">
                            @if ($item->whatsapp ?? null)
                                <div class="col-3">
                                    <a style="color: green" href="https://wa.me/{{ $item->whatsapp }}" target="_blank"
                                        class="wa-btn d-flex justify-content-center align-items-center"><span
                                            class="details"></span><i class="fa fa-3x fa-whatsapp"></i></a>
                                </div>
                            @endif
                            <div class="col-9" @if ($item->whatsapp) style="padding-left:0px" @endif>
                                <a href="{{ $detail_link }}"
                                    class="details-btn d-flex justify-content-center align-items-center"><span
                                        class="details">Details</span><span class="lnr lnr-arrow-right"></span></a>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <script src="{{ asset('plugins/fullcalendar/main.min.js') }}"></script>

    <script>
        $(function() {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next',
                },
                // height: 'auto',

                locale: 'id',
                timeZone: 'local',
                // showNonCurrentDates: false,

                eventClick: function(info) {
                    let waktu = info.event.end ?
                        `${moment(info.event.start).format('dddd, DD MMMM')} - ${moment(info.event.end).format('dddd, DD MMMM')}` :
                        moment(info.event.start).format('dddd, DD MMMM');


                    let content = `${waktu}<br>Tempat : ${info.event.extendedProps.tempat || '-'}`;

                    // Tautan "Selengkapnya" yang mengarah ke URL dinamis
                    let selengkapnyaLink =
                        `<a href="/agenda/detail/${info.event.id}?item=${encodeURIComponent(info.event.title)}" class="btn btn-primary">Selengkapnya</a>`;

                    $.confirm({
                        type: 'blue',
                        columnClass: 'medium',
                        title: info.event.title,
                        content: content,
                        buttons: {
                            selengkapnya: {
                                btnClass: 'btn-primary',
                                action: function() {
                                    window.location.href =
                                        `/agenda/detail/${info.event.id}?item=${encodeURIComponent(info.event.title)}`;
                                }
                            },
                        },
                        closeIcon: true, // Menampilkan ikon "X" di pojok kanan atas
                        closeIconClass: 'fa fa-times',
                    })
                },

                datesSet: function(info) {
                    let events = calendar.getEvents();
                    if (events.length) events.forEach(event => event.remove());

                    $('#calendar').loading();

                    $.post(`/agenda/ajax`, {
                        month: moment(info.start).add(1, 'M').format('YYYY-MM')
                    }, function(e, textStatus, xhr) {
                        $('#calendar').loading('stop');
                        if (!e.status) return toastr.error(e.message ||
                            'Tidak dapat mengambil data!');

                        e.data.event.forEach(ev => calendar.addEvent(ev))

                    }, 'json').fail(e => {
                        $('#calendar').loading('stop');
                        toastr.error('Server tidak merespon!')
                    })
                },
            });


            calendar.render();
        });
    </script>
@endsection
