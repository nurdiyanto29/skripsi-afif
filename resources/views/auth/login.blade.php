<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/login/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/login/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/login/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('frontend/login/css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
    
        .btn-primary {
            color: #fff;
            background-color: #6c63ff !important;
            border-color: #6c63ff !important ;
        }
    </style>


    <title>Login</title>
</head>

<body>



    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="https://www.jogjasuper.co.id/wp-content/uploads/2023/01/lokasi-Pantai-Slili.jpg" alt="Image"

                    {{-- <img src="{{ asset('frontend/login/images/undraw_remotely_2j6y.svg') }}" alt="Image" --}}
                        class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Login</h3>
                                @if (Session::has('error'))
                                    <div class="alert alert-warning alert-dismissible fade show pesan_alert"
                                        role="alert">
                                        {{ Session::get('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('postlogin') }}" method="POST"
                                class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>

                                {{-- <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0"><span class="caption">Remember
                                            me</span>
                                        <input type="checkbox" checked="checked" />
                                        <div class="control__indicator"></div>
                                    </label>
                                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot
                                            Password</a></span>
                                </div> --}}

                                <input type="submit" value="Log In" class="btn btn-block btn-primary">

                                {{-- <span class="d-block text-center my-4 text-muted">&mdash; or login with &mdash;</span>
                                <div class="text-center">
                                    <div class="social-login">
                                        <a href="#" class="facebook">
                                            <span class="icon-facebook mr-3"></span>
                                        </a>
                                        <a href="#" class="twitter">
                                            <span class="icon-twitter mr-3"></span>
                                        </a>
                                        <a href="{{url('authorized/google')}}" class="google">
                                            <span class="icon-google mr-3"></span>
                                        </a>
                                    </div>
                                </div>
                                 --}}
                            </form><br>
                            <div style="text-align: center">
                                <p>Belum Punya akun?</p> 
                                <a href="/register">Register</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="frontend/login/js/jquery-3.3.1.min.js"></script>
    <script src="frontend/login/js/popper.min.js"></script>
    <script src="frontend/login/js/bootstrap.min.js"></script>
    <script src="frontend/login/js/main.js"></script>
</body>

</html>
