@extends('frontend.fe_layout.main')

@section('content')
    <style>
        .banner-area {
            background-image: url('{{ asset($_setting['img_header']) }}')
        }
    </style>
    <!-- start banner Area -->
    <!-- start banner Area -->
    <section class="banner-area relative about-banner" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        {{$opt['head']}}
                    </h1>
                    <p class="text-white link-nav"><a href="/">Beranda </a> <span class="lnr lnr-arrow-right"></span> <a
                            href="">{{$opt['head']}}</a></p>
                </div>
            </div>
        </div>
    </section>
    <br>
    <section class="course-mission-area pb-120">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10"></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div id="peta_wilayah" class="table-responsive" style="background: #fff;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Padukuhan</th>
                                    <th scope="col">Jumlah Kamling</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center"> <span class="fa fa-spin fa-spinner"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $.post("{{ route('kamling.ajax') }}", {
                        type: 'table'
                    }, function(e) {
                        if (!e.status) return $('#peta_wilayah tbody td').html('Belum ada data');
                        let dt = e.data.item.map(x => `
                            <tr class="incTbl">
                                <td><a href="/kamling/${x.idd}">${x.dusun || ''}</td>
                                <td>${x.kamling || '0'}</td>
                            </tr>
                        `).join('');
                        ;
                            $('#peta_wilayah tbody').html(dt);
                    }, "json")
                    .fail(e => $('#peta_wilayah tbody td').html('Tidak bisa mengambil data'))
            });
        </script>
@endsection
