@extends('frontend.main')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('content')
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Booking</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
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
                            @foreach ($objek as $item)
                                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="package-item">
                                        <!-- ID unik untuk setiap elemen objek wisata -->
                                        <div id="objek_{{ $item->id }}">
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
                                                <p>{!! sederhana($item->deskripsi, 50) !!}</p>
                                                <!-- Tombol "pilih" atau "batalkan" dengan event listener -->
                                                <div class="d-flex justify-content-center mb-2">
                                                    @if ($item->is_selected)
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-danger px-3 border-end"
                                                            style="border-radius: 30px"
                                                            onclick="togglePilihObjekWisata(event, {{ $item->id }}, '{{ $item->nama }}')">Batalkan</a>
                                                    @else
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-primary px-3 border-end"
                                                            style="border-radius: 30px"
                                                            onclick="togglePilihObjekWisata(event, {{ $item->id }}, '{{ $item->nama }}')">Pilih</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="booking-form">
                        <h1 class="mb-4">Pesan Disini</h1>
                        <form action="{{ url('buat_pesanan') }}" method="POST" onsubmit="validateForm(event)">
                            @csrf

                            <input type="hidden" id="objek_id" name="objek_id[]" value="">

                            <div class="form-group">
                                <label for="travel">Travel</label>
                                <input type="hidden" class="form-control" id="travel_id" name="travel_id"
                                    value="{{ $travel->id }}" readonly>
                                <input type="text" class="form-control" id="travel" name="travel"
                                    value="{{ $travel->nama }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="travel">Jumlah Kursi</label>
                                <input type="text" class="form-control" value="{{ $travel->jml_kursi }}" readonly>
                            </div>
                            <!-- Area teks untuk menampilkan objek wisata yang dipilih -->
                            <div class="form-group" style="display: none">
                                <label for="objek_wisata">Objek Wisata Dipilih</label>
                                <textarea class="form-control" id="objek_wisata" name="objek_wisata[]" rows="5" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jml_orang">Untuk Berapa Orang?</label>
                                <input type="text" class="form-control" id="jml_orang" name="jml_orang" value=""
                                    required>
                                <span id="max_kursi" style="display:none;">{{ $travel->jml_kursi }}</span>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Pilih Tanggal Liburan</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" value=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="jam">Pilih Jam</label>
                                <input type="time" class="form-control" id="jam" name="jam" value=""
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ubah area teks objek wisata dipilih menjadi input hidden dengan name="objek_id[]" -->



        </div>
    </div>
    <!-- Booking End -->


    <!-- Process Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Proses</h6>
                <h1 class="mb-5">3 Langkah Traveling</h1>
            </div>
            <div class="row gy-5 gx-4 justify-content-center">
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-globe fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Pilih Travel dan Destinasi Wisata</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Temukan destinasi impian Anda dan pilih travel yang sesuai dengan kebutuhan Anda.
                            Telusuri berbagai pilihan tempat wisata yang menarik dan siap untuk dieksplorasi. Mulailah
                            petualangan Anda dengan memilih destinasi yang tepat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-dollar-sign fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Melakukan Pembayaran</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Setelah memilih destinasi dan travel, saatnya untuk melakukan pembayaran. Proses
                            pembayaran secara aman dan nyaman untuk memastikan perjalanan Anda berjalan lancar. Nikmati
                            kemudahan dalam pembayaran dan bersiaplah untuk pengalaman wisata yang tak terlupakan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-plane fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Mulai Berwisata</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Setelah pembayaran selesai, Anda siap untuk memulai petualangan wisata Anda.
                            Bersiaplah untuk mengeksplorasi tempat-tempat baru, menikmati pengalaman yang luar biasa, dan
                            membuat kenangan tak terlupakan. Mulailah petualangan Anda dan nikmati setiap momennya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Start -->
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
      $(function() {
        $(function() {
    $.ajax({
        url: '/get_travel_id/{{ $travel->id }}', // Ganti URL dengan URL yang sesuai di proyek Anda
        type: 'GET',
        success: function(response) {
            var disabledDates = response.pesanan;

            // Mendapatkan tanggal besok
            var tomorrow = moment().add(1, 'day').format('YYYY-MM-DD');

            $('#tanggal').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2024,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'YYYY-MM-DD' // Format tanggal Y-M-D
                },
                isInvalidDate: function(date) {
                    var formattedDate = date.format('YYYY-MM-DD');
                    return disabledDates.includes(formattedDate) || formattedDate < tomorrow;
                }
            });
        }
    });
});

});











        document.getElementById('jml_orang').addEventListener('input', function() {
            var inputVal = parseInt(this.value);
            var maxKursi = parseInt(document.getElementById('max_kursi').textContent);

            if (inputVal > maxKursi) {
                alert("Maaf, jumlah orang tidak boleh melebihi jumlah kursi yang tersedia.");
                this.value = maxKursi; // Set nilai input menjadi nilai maksimal
            }
        });


        // Array untuk menyimpan id objek wisata yang dipilih
        var selectedObjekIds = [];

        // Fungsi untuk menangani pilihan objek wisata
        function togglePilihObjekWisata(event, id, nama) {
            event.preventDefault();
            var objekTextarea = document.getElementById('objek_wisata');
            var currentContent = objekTextarea.value;
            var objekId = 'objek_' + id;

            // Toggle id objek wisata dalam array selectedObjekIds
            var index = selectedObjekIds.indexOf(id);
            if (index === -1) {
                // Jika belum dipilih, tambahkan ke daftar objek wisata yang dipilih
                selectedObjekIds.push(id);
            } else {
                // Jika sudah dipilih, hapus dari daftar objek wisata yang dipilih
                selectedObjekIds.splice(index, 1);
            }

            // Perbarui konten area teks objek wisata yang dipilih
            objekTextarea.value = currentContent;

            // Perbarui nilai input hidden objek_id dengan array id objek wisata yang dipilih
            document.getElementById('objek_id').value = selectedObjekIds.join(',');

            // Ubah tampilan tombol
            if (index === -1) {
                // Objek wisata dipilih
                event.target.innerText = "Batalkan";
                event.target.classList.remove('btn-primary');
                event.target.classList.add('btn-danger');
            } else {
                // Objek wisata dibatalkan
                event.target.innerText = "Pilih";
                event.target.classList.remove('btn-danger');
                event.target.classList.add('btn-primary');
            }
        }

        // Fungsi untuk memeriksa apakah ada objek wisata yang dipilih sebelum mengirim formulir
        function validateForm(event) {
            if (selectedObjekIds.length === 0) {
                event.preventDefault();
                alert("Pilih setidaknya satu objek wisata!");
            }
        }
    </script>
@endpush
