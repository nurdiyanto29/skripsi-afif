@extends('frontend.fe_layout.main')

@section('content')
    <style>
        .banner-area {
            background-image: url('{{ asset($_setting['img_header']) }}')
        }

        .image-preview {
            position: relative;
            width: 100%;
            height: 100px;
            border: 2px dashed #ccc;
            text-align: center;
            cursor: pointer;
        }

        .image-label {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .plus-icon {
            font-size: 40px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .change-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            color: #555;
            display: none;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.5);
            /* Warna latar belakang transparan */
            padding: 5px 10px;
            border-radius: 25%;
            /* Radius 50% */
            backdrop-filter: blur(20px);
            /* Efek blur latar belakang (tersedia di browser modern) */
        }

        #image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .image-preview.has-image #image-preview {
            display: block;
        }

        .hidden {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- start banner Area -->
    <!-- start banner Area -->
    <section class="banner-area relative about-banner" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        {{ $opt['page'] }}
                    </h1>
                    <p class="text-white link-nav"><a href="/">Beranda </a> <span class="lnr lnr-arrow-right"></span>
                        <a href="">{{ $opt['page'] }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <br>
    <section class="contact-page-area section-gap">
        <div class="container">
            <div class="row">
                @if ($opt['page'] == 'Kotak Saran')
                    <div class="map-wrap" style="width:100%; height: 300px;">
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.it/maps?q=Kantor kelurahan tridadi&output=embed"></iframe>
                    </div>
                @endif
                <div class="col-lg-5 d-flex flex-column address-wrap">
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-home"></span>
                        </div>
                        <div class="contact-details">
                            <h5>Tridadi Sleman</h5>
                            <p>
                                {{ $opt['alamat'] }}
                            </p>
                        </div>
                    </div>
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-phone-handset"></span>
                        </div>
                        <div class="contact-details">
                            <h5>{{ $opt['tlp'] }}</h5>
                        </div>
                    </div>
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-envelope"></span>
                        </div>
                        <div class="contact-details">
                            <h5>{{ $opt['email'] }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="form-area contact-form text-right" id="myForm" method="post"
                        action="{{ route('kotak_saran.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <input type="hidden" value="{{ $opt['type'] }}" name="type">
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input name="nama" placeholder="Nama" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Nama'" class="common-input mb-20 form-control"
                                    required="" type="text">


                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input name="email" placeholder="Email"
                                    pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'"
                                    class="common-input mb-20 form-control" required="" type="email">

                                @error('subjek')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input name="subjek" placeholder="Subyek" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Subyek'" class="common-input mb-20 form-control"
                                    required="" type="text">

                                @error('gambar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-lg-6 form-group">
                                @error('pesan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <textarea class="common-textarea form-control" name="pesan" placeholder="Pesan" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Pesan'" required=""></textarea>
                                <br>
                                <div class="image-preview">
                                    <label for="image-input" class="image-label">
                                        <span class="plus-icon">+</span>
                                        <span class="change-text"> Change</span>
                                        <img id="image-preview" src="#" alt=" " />
                                    </label>
                                    <input type="file" id="image-input" name="gambar" accept="image/*" class="hidden" />
                                </div>
                            </div>

                            {{-- <div class="col-lg-6 form-group">
                            </div>
                            <div class="col-lg-6 form-group">

                            </div> --}}

                            <div class="col-lg-12">
                                <div class="alert-msg" style="text-align: left;"></div>
                                <button class="genric-btn btn-block primary" style="float: right;">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script>
        $('#image-input').change(function (e) { 
            e.preventDefault();
            
            let oFile = $(' #image-input ')[0].files[0] || null;
            if(!oFile) return $(' #image-input ').val('');

            let arr1 = new Array;
            arr1 = oFile.name.split('\\');
            let len = arr1.length;
            let img1 = arr1[len - 1];
            let filext = img1.substring(img1.lastIndexOf(".") + 1);

            let rFilter = /^(jpg|jpeg|png|jpg|jpeg)$/i;

            if (! rFilter.test(filext)) {
                return $(' #image-input ').val('');
            }

            let oFReader = new FileReader();
            oFReader.readAsDataURL(oFile);
            
            let oImage	= document.getElementById("image-preview");
            oFReader.onload = function (oFREvent) {
                oImage.src = oFREvent.target.result;
                oImage.style.display="block";
                $('.change-text').show();
                $(".plus-icon").hide();
                $(".image-preview").addClass("has-image");
            };
            
        });

        $(document).ready(function() {

            @if (session('success'))
                toastr.success('{{ session('success') }}')
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}')
            @endif

            @if ($errors->any())
                toastr.error('Form input tidak valid!');
            @endif

            $('#myForm').submit(function(e) {
                $(this).hide();
                $(this).parent().loading();

            });
        });
    </script>
@endsection
