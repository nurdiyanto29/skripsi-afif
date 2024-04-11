@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info mt-5">
                <img src="/img/logo.jpg" alt="Logo" class="brand-image  elevation-1" style="background: white;" >
                SELAMAT DATANG <b>{{Str::upper(Auth::user()->name)}}</b>. SELAMAT BEKERJA
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    

    {{-- <script src="{{ asset('js/dashboard_chart.js') }}"></script> --}}
<script>

chart_data = {};

my_chart = new Chart('chart', {
    type: 'pie',
    data: {},
    options: {
        legend: {
            position: "bottom"
        },
        responsive: true,
        plugins: { }
    },
});


</script>
@endpush
