@extends('layout.admin')

@push('css')
    <style>
        .mt-4,
        .my-4 {
            margin-top: 1rem !important;
        }

        .info-box .progress {
            background-color: rgba(0, 0, 0, .125);
            height: .5rem;
            margin: 5px 0;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
            background-color: #def6ff;
        }

        .card-text {
            font-weight: bold
        }

        .card-body-d {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
            /* background-color: #d5f1fc; */
        }

        .form-filter {
            float: right;
            margin-bottom: 1rem !important;
            margin-top: 1rem !important
        }
    </style>
@endpush
@section('content')
    <div class="tocanvas">
        <div class="row">
            <div class="col-12">
                <h5 class="mt-4 mb-2" style="float: left">DASHBOARD</h5>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>12</h3>
                            <p>UMKM</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>333</h3>
                            <p>ODGJ</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Kamling</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>4</h3>
                            <p>Penduduk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script src="{{ asset('js/dashboard_chart.js') }}"></script>
    <script></script>
@endpush
