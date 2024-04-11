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
                        Wilayah Administratif
                    </h1>
                    <p class="text-white link-nav"><a href="/">Beranda </a> <span class="lnr lnr-arrow-right"></span> <a
                            href="">Wilayah Administratif</a></p>
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
                                    <th scope="col">Nama Kepala Padukuhan</th>
                                    <th scope="col">Jumlah RT</th>
                                    <th scope="col">Jumlah KK</th>
                                    <th scope="col">Jiwa</th>
                                    <th scope="col">Laki-laki</th>
                                    <th scope="col">Perempuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center"> <span class="fa fa-spin fa-spinner"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.6.1/randomColor.min.js"
        integrity="sha512-vPeZ7JCboHcfpqSx5ZD+/jpEhS4JpXxfz9orSvAPPj0EKUVShU2tgy7XkU+oujBJKnWmu4hU7r9MMQNWPfXsYw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(function() {
            $.post("{{ route('dusun.ajax') }}", {
                    type: 'table'
                }, function(e) {
                    if (!e.status) return $('#peta_wilayah tbody td').html('Belum ada data');
                    let dt = e.data.item.map(x => `
                        <tr class="incTbl">
                            <td>${x.dusun || ''}</td>
                            <td>${x.kadus || ''}</td>
                            <td>${x.rt || ''}</td>
                            <td>${x.jml_kk || ''}</td>
                            <td>${x.jiwa || ''}</td>
                            <td>${x.lk || ''}</td>
                            <td>${x.pr  || ''} </td>
                        </tr>
                    `).join('');
                    dt += `
                            <tr>
                                <th></th>
                                <th></th>
                                <th>${e.data.total.rt|| ''}</th>
                                <th>${e.data.total.jml_kk|| ''}</th>s
                                <th>${e.data.total.jiwa || ''}</th>
                                <th>${e.data.total.lk || ''}</th>
                                <th>${e.data.total.pr || ''}</th>  
                            </tr>
                        `;
                        $('#peta_wilayah tbody').html(dt);
                }, "json")
                .fail(e => $('#peta_wilayah tbody td').html('Tidak bisa mengambil data'))
        });
    </script>
@endsection
{{-- @push('js') --}}
{{-- @endpush --}}
