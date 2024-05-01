@extends('frontend.main')

@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Pembayaran</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Pembayaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <style>
        .booking {
            overflow-y: auto;
            max-height: 600px;
            /* Atur tinggi maksimum yang diinginkan */
        }

        .package-item .overflow-hidden {
            height: 150px;
            /* Atur tinggi gambar sesuai kebutuhan Anda */
            overflow: hidden;
        }

        .package-item .overflow-hidden img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <!-- Booking Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">

            <div class="row g-5 align-items-center">
                <div class="col-md-8">
                    <div class="booking p-5">
                        <!-- Konten Daftar Objek Wisata -->
                        <div class="row g-4 justify-content-center overflow-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Detail Pesanan</h5>
                                    <table class="table">
                                        <tr>
                                            <th style="text-align: center" colspan="3">Travel</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" scope="col">Nama Travel</th>
                                            <td scope="col">{{ $pesanan->travel->nama ?? null }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="2" scope="col">Transmisi</th>
                                            <td scope="col">{{ $pesanan->travel->tranmisi ?? null }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" scope="col">Sopir</th>
                                            <td scope="col">{{ $pesanan->travel->sopir->nama ?? null }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" scope="col">Harga Travel</th>
                                            <td scope="col">{{ nominal($pesanan->travel->harga) ?? null }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="3" style="text-align: center"> </th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center" colspan="3">Nominal Yang harus Dibayarkan</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" sc3pe="col">Harga Travel</th>
                                            <td style="text-align: right" scope="col">
                                                {{ nominal($pesanan->travel->harga) ?? null }}</td>
                                        </tr>
                                        @php
                                            $total_biaya_masuk = 0;
                                        @endphp
                                        @foreach ($pesanan->objek_wisata as $item)
                                            @php
                                                $subtotal_biaya_masuk = $item->biaya_masuk * $pesanan->jumlah_wisatawan;
                                                $total_biaya_masuk += $subtotal_biaya_masuk;
                                            @endphp
                                            <tr>
                                                <td scope="col">{{ $item->nama }}</td>
                                                <td scope="col">{{ nominal($item->biaya_masuk) }} X
                                                    {{ $pesanan->jumlah_wisatawan }}</td>
                                                <td style="text-align: right" scope="col">
                                                    {{ nominal($item->biaya_masuk * $pesanan->jumlah_wisatawan) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total Yang harus dibayarkan</th>
                                            <th style="text-align: right">
                                                {{ nominal($total_biaya_masuk + $pesanan->travel->harga) }}</th>
                                        </tr>


                                        <!-- Tambahkan baris tabel sesuai dengan detail pesanan -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Detail Objek Dipilih</h5>
                                    <table class="table">
                                        @php
                                            $x = 1;
                                        @endphp
                                        <tr>
                                            <th style="width: 50px" scope="col">NO</th>
                                            <th scope="col">Nama Objek Wisata</th>
                                            <th scope="col">Harga Tiket Masuk/@</th>
                                            <th scope="col">Lokasi</th>
                                        </tr>
                                        @foreach ($pesanan->objek_wisata as $item)
                                            <tr>
                                                <td style="width: 50px" scope="col">{{ $x++ }}</td>
                                                <td scope="col">{{ $item->nama }}</td>
                                                <td scope="col">{{ nominal($item->biaya_masuk) }}</td>
                                                <td scope="col">{{ $item->lokasi }}</td>
                                            </tr>
                                        @endforeach

                                        <!-- Tambahkan baris tabel sesuai dengan detail pesanan -->
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    @if ($pesanan->pembayaran)
                        <div class="booking-form">
                            <h1 class="mb-4">Terimakasih Telah Melakukan Pembayaran</h1>
                        </div>
                    @endif
                    @if (!$pesanan->pembayaran)
                        <div class="booking-form">
                            <h1 class="mb-4">Segera Lakukan Pembayaran</h1>
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Dengan melakukan transfer di</h5>
                                        <p>425127128 (BCA)</p>
                                        <p>7484337128 (BRI)</p>
                                </div>
                            </div>
                            <br>
                            {{ $total_biaya_masuk + $pesanan->travel->harga }}
                            <form action="{{ url('proses_bayar') }}" method="Post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="pesanan_id" name="pesanan_id"
                                    value="{{ $pesanan->id }}">
                                <div class="form-group">
                                    <label>Masukkan Nominal Yang dibayarkan</label>
                                    <input type="text" class="form-control" id="jumlah_pembayaran"
                                        name="jumlah_pembayaran" value="" required>
                                </div>
                                <p id="error-message" style="color: red; display: none;">Jumlah pembayaran harus sama dengan
                                    {{ $total_biaya_masuk + $pesanan->travel->harga }}</p>

                                <div class="form-group">
                                    <label>Upload Bukti bayar</label>
                                    <input type="file" class="form-control" id="foto_pembayaran" name="foto_pembayaran"
                                        value="" required>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Proses Bayar</button>
                            </form>

                            <script>
                                // Mendapatkan elemen input jumlah pembayaran
                                var inputJumlahPembayaran = document.getElementById('jumlah_pembayaran');

                                // Mendapatkan nilai total yang diharapkan
                                var totalDiharapkan = {{ $total_biaya_masuk + $pesanan->travel->harga }};

                                // Memvalidasi input saat pengguna mengetik
                                inputJumlahPembayaran.addEventListener('input', function() {
                                    // Menghapus karakter selain angka
                                    this.value = this.value.replace(/\D/g, '');

                                    // Memeriksa apakah nilai input sama dengan total yang diharapkan
                                    if (parseInt(this.value) === totalDiharapkan) {
                                        document.getElementById('error-message').style.display = 'none'; // Sembunyikan pesan error
                                        document.getElementById('submitBtn').disabled = false; // Aktifkan tombol submit
                                    } else {
                                        document.getElementById('error-message').style.display = 'block'; // Tampilkan pesan error
                                        document.getElementById('submitBtn').disabled = true; // Nonaktifkan tombol submit
                                    }
                                });
                            </script>

                            {{-- {{$total_biaya_masuk + $pesanan->travel->harga}}
                        <form action="{{ url('proses_bayar') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" id="pesanan_id" name="pesanan_id" value="{{$pesanan->id}}">
                            <div class="form-group">
                                <label>Masukkan Nominal Yang dibayarkan</label>
                                <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Upload Bukti bayar</label>
                                <input type="file" class="form-control" id="foto_pembayaran" name="foto_pembayaran" value=""
                                    required>
                            </div>
                            <br>
                           
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form> --}}
                        </div>
                    @endif
                    {{-- <div class="booking-form">
                        <h1 class="mb-4">Segera Lakukan Pembayaran</h1>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Dengan melakukan transfer di</h5>
                                    <p>425127128 (BCA)</p>
                                    <p>7484337128 (BRI)</p>
                            </div>
                        </div>
                        <br>
                        <form action="{{ url('proses_bayar') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" id="pesanan_id" name="pesanan_id" value="{{$pesanan->id}}">
                            <div class="form-group">
                                <label>Masukkan Nominal Yang dibayarkan</label>
                                <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Upload Bukti bayar</label>
                                <input type="file" class="form-control" id="foto_pembayaran" name="foto_pembayaran" value=""
                                    required>
                            </div>
                            <br>
                           
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div> --}}
                </div>
            </div>

            <!-- Ubah area teks objek wisata dipilih menjadi input hidden dengan name="objek_id[]" -->



        </div>
    </div>
    <!-- Booking End -->
@endsection
