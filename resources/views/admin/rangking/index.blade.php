@extends('layout.admin')
@push('css')
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .kelap-kelip {
            animation: blink 2s infinite;
            color: red;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    @php
        $urlPath = request()->path(); // Mendapatkan path URL saat ini
        $segments = explode('/', $urlPath); // Memecah path menjadi segmen berdasarkan '/'.
        $title = isset($segments[1]) ? $segments[1] : '';
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card  card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Penghitungan Sub Kriteria, Normalisasi , & Ranking
                        </h3>
                    </div>
                    <div class="card-body">

                        {{-- @if ($pembanding == true) --}}
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="sub_kriteria-tab" data-toggle="pill" href="#sub_kriteria"
                                        role="tab" aria-controls="sub_kriteria" aria-selected="true">Penghitungan Sub
                                        Kriteria</a>

                                    <a class="nav-link" id="normalisasi-tab" data-toggle="pill" href="#normalisasi"
                                        role="tab" aria-controls="normalisasi" aria-selected="false">Penghitungan
                                        Normalisasi</a>
                                    <a class="nav-link" id="vert-rangking-tab" data-toggle="pill" href="#vert-rangking"
                                        role="tab" aria-controls="vert-rangking" aria-selected="false">Tabel
                                        Ranking</a>
                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <div class="tab-pane text-left fade" id="normalisasi" role="tabpanel"
                                        aria-labelledby="normalisasi-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                @php
                                                    $maxValues = [];
                                                    // Loop melalui hasil untuk setiap produk
                                                    foreach ($hasil as $produkData) {
                                                        // Loop melalui kriteria
                                                        foreach ($kriteria as $kriteriaID) {
                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
    
                                                            // Pastikan ada data sub-kriteria
                                                            if ($subKriteriaData) {
                                                                $bobot = $subKriteriaData['bobot'];
    
                                                                // Jika nilai maksimum belum ada atau nilai saat ini lebih besar
                                                                if (!isset($maxValues[$kriteriaID]) || $bobot > $maxValues[$kriteriaID]) {
                                                                    $maxValues[$kriteriaID] = $bobot;
                                                                }
                                                            }
                                                        }
                                                    }
    
                                                    $minValues = [];
    
                                                    // Loop melalui hasil untuk setiap produk
                                                    foreach ($hasil as $produkData) {
                                                        // Loop melalui kriteria
                                                        foreach ($kriteria as $kriteriaID) {
                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
    
                                                            // Pastikan ada data sub-kriteria
                                                            if ($subKriteriaData) {
                                                                $bobot = $subKriteriaData['bobot'];
    
                                                                // Jika nilai minimum belum ada atau nilai saat ini lebih kecil
                                                                if (!isset($minValues[$kriteriaID]) || $bobot < $minValues[$kriteriaID]) {
                                                                    $minValues[$kriteriaID] = $bobot;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <table id="example1"
                                                    class="table table-bordered table-striped ex">
                                                    <thead>
                                                        <tr style="text-align: center">
                                                            <th>Alternative </th>
                                                            @foreach ($kriteria as $kriteriaID)
                                                                <th>{{ $kriteriaID }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasil as $produkData)
                                                            <tr>
                                                                <td>{{ $produkData['produk_id'] }}</td>
    
                                                                @foreach ($kriteria as $kriteriaID)
                                                                    <td>
                                                                        @php
                                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
                                                                            $model = 'App\Models\Kriteria';
                                                                            $c = $model::where('kode_kriteria', $kriteriaID)->first();
    
                                                                            if ($subKriteriaData) {
                                                                                $bobot = $subKriteriaData['bobot'];
                                                                                $jenisAtribut = $c->jenis_atribut;
    
                                                                                if ($jenisAtribut == 'B') {
                                                                                    // Bagi bobot dengan nilai maksimum
                                                                                    $maxValue = $maxValues[$kriteriaID];
                                                                                    if ($maxValue != 0) {
                                                                                        echo round($bobot / $maxValue, 2);
                                                                                    } else {
                                                                                        echo 'Undefined'; // Mencegah pembagian oleh nol
                                                                                    }
                                                                                } elseif ($jenisAtribut == 'C') {
                                                                                    // Bagi nilai minimum dengan bobot
                                                                                    $minValue = $minValues[$kriteriaID];
                                                                                    if ($minValue != 0) {
                                                                                        echo round($minValue / $bobot, 2);
                                                                                    } else {
                                                                                        echo 'Undefined'; // Mencegah pembagian oleh nol
                                                                                    }
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="vert-rangking" role="tabpanel"
                                        aria-labelledby="vert-rangking-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                @php
                                                    $maxValues = [];
    
                                                    // Loop melalui hasil untuk setiap produk
                                                    foreach ($hasil as $produkData) {
                                                        // Loop melalui kriteria
                                                        foreach ($kriteria as $kriteriaID) {
                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
    
                                                            // Pastikan ada data sub-kriteria
                                                            if ($subKriteriaData) {
                                                                $bobot = $subKriteriaData['bobot'];
    
                                                                // Jika nilai maksimum belum ada atau nilai saat ini lebih besar
                                                                if (!isset($maxValues[$kriteriaID]) || $bobot > $maxValues[$kriteriaID]) {
                                                                    $maxValues[$kriteriaID] = $bobot;
                                                                }
                                                            }
                                                        }
                                                    }
    
                                                    $minValues = [];
    
                                                    // Loop melalui hasil untuk setiap produk
                                                    foreach ($hasil as $produkData) {
                                                        // Loop melalui kriteria
                                                        foreach ($kriteria as $kriteriaID) {
                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
    
                                                            // Pastikan ada data sub-kriteria
                                                            if ($subKriteriaData) {
                                                                $bobot = $subKriteriaData['bobot'];
    
                                                                // Jika nilai minimum belum ada atau nilai saat ini lebih kecil
                                                                if (!isset($minValues[$kriteriaID]) || $bobot < $minValues[$kriteriaID]) {
                                                                    $minValues[$kriteriaID] = $bobot;
                                                                }
                                                            }
                                                        }
                                                    }
    
                                                    // dd($maxValues, $minValues);
    
                                                @endphp
                                                <table id="rankingTable" 
                                                    class="table table-bordered table-striped ex">
                                                    <thead>
                                                        <tr>
                                                            <th>Ranking</th>
                                                            <th>Nama (Alternatif)</th>
                                                            <th>Bobot</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            // Inisialisasi array untuk menyimpan total nilai
                                                            $totalScores = [];
    
                                                            // Hitung total nilai untuk setiap produk
                                                            foreach ($hasil as $produkData) {
                                                                $totalScore = 0;
                                                                foreach ($kriteria as $kriteriaID) {
                                                                    $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
                                                                    $model = 'App\Models\Kriteria';
                                                                    $c = $model::where('kode_kriteria', $kriteriaID)->first();
    
                                                                    if ($subKriteriaData) {
                                                                        $bobot = $subKriteriaData['bobot'];
                                                                        $jenisAtribut = $c->jenis_atribut;
                                                                        $bobot_kriteria = $c->bobot_kriteria / 100;
    
                                                                        if ($jenisAtribut == 'B') {
                                                                            $maxValue = $maxValues[$kriteriaID];
                                                                            if ($maxValue != 0) {
                                                                                $totalScore += $bobot_kriteria * ($bobot / $maxValue);
                                                                            } else {
                                                                                $totalScore += 0; // Mencegah pembagian oleh nol
                                                                            }
                                                                        } elseif ($jenisAtribut == 'C') {
                                                                            $minValue = $minValues[$kriteriaID];
                                                                            if ($minValue != 0) {
                                                                                $totalScore += $bobot_kriteria * ($minValue / $bobot);
                                                                            } else {
                                                                                $totalScore += 0; // Mencegah pembagian oleh nol
                                                                            }
                                                                        }
                                                                    }
                                                                }
    
                                                                // Simpan total nilai ke dalam array
                                                                $totalScores[$produkData['produk_id']] = $totalScore;
                                                            }
    
                                                            // Urutkan produk berdasarkan total nilai dari yang tertinggi
                                                            arsort($totalScores);
    
                                                            // Inisialisasi peringkat
                                                            $rank = 1;
                                                        @endphp
    
                                                        @foreach ($totalScores as $produkID => $totalScore)
                                                            @php
    
                                                                $idd = $produkID;
                                                                $produk_name = App\Models\Produk::where('produk_id', $idd)->first();
    
                                                                $produk = $produk_name->nama_produk . ' (' . $idd . ') ';
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $rank }}</td>
                                                                <td>{{ $produk }}</td>
                                                                <td>{{ round($totalScore, 2) }}</td>
                                                            </tr>
                                                            @php
                                                                // Tingkatkan peringkat
                                                                $rank++;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade active show" id="sub_kriteria" role="tabpanel"
                                        aria-labelledby="sub_kriteria-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="example1" 
                                                    class="table table-bordered table-striped ex">
                                                    <thead>
                                                        <tr style="text-align: center">
                                                            <th>Alternative </th>
                                                            @foreach ($kriteria as $kriteriaID)
                                                                <th>{{ $kriteriaID }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasil as $produkData)
                                                            <tr>
                                                                <td>{{ $produkData['produk_id'] }}</td>
                                                                @foreach ($kriteria as $kriteriaID)
                                                                    <td>
                                                                        @php
                                                                            $subKriteriaData = $produkData['data_kriteria'][$kriteriaID];
                                                                            if ($subKriteriaData) {
                                                                                echo $subKriteriaData['bobot'];
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @else --}}

                        {{-- @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"></script>
    <script>
        $(document).ready(function() {
            $('.ex').DataTable({
                "lengthMenu": [5, 10, 15, 20, 35], // Menampilkan opsi jumlah entri per halaman
                "pageLength": 5, // Jumlah entri per halaman default
                "pagingType": "full_numbers",
                "searching": false,
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ data", // Label untuk lengthMenu
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", // Label untuk informasi entri
                    "infoEmpty": "Showing 0 to 0 of 0 entries", // Label ketika tidak ada entri
                    "infoFiltered": "(filtered from _MAX_ total entries)", // Label untuk informasi entri yang difilter
                    "paginate": {
                        "first": "",
                        "last": "",
                        "next": "",
                        "previous": ""
                    }
                },
                "ordering": false

            });
        });
    </script>
@endsection
