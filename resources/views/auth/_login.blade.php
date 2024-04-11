<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="description" content="login">
    <meta name="author" content="Neoxdev" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {{-- <link rel="icon" type="image/png" href="{{ asset('img/logo.svg') }}"> --}}

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> --}}

    <style>
        html {
    width: 100%;
    background: linear-gradient(45deg, rgba(39, 31, 189, 1) 0%, rgba(26, 179, 217, 1) 100%);
}

body {
    background-color: transparent;
    color: #fff;
}


/* canvas {
    display: block;
    vertical-align: bottom;
} */

.back1 {
    width: 100%;
    height: 100%;
    position: fixed;
    background: url("./css/background.jpeg");;
    top: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: no-repeat;
    opacity: 0.1;
}
#particles-js {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;

}

.login_img {
    width: 250px;
    /* margin-top: 40px */
}

.login-card-body,
.register-card-body {
    background-color: #fff;
    border-top: 0;
    color: #666;
    padding: 20px;
    padding-bottom: 2px;
}

.login-title {
    margin-top: 5rem;
}

.login-title p {
    margin-bottom: 4px;
    font-size: 2rem;
    line-height: 35px;
}

.login-subtitle h5 {
    font-size: 6rem;
    margin: 0.6rem 0;
    font-weight: 600;
}

.login-subtitle p {
    margin-bottom: 0.1rem;
    font-size: 1.8rem;
    font-weight: lighter;
}

.login-page {
    background: none;
    height: unset;
    margin-top: 10vh;
    -ms-flex-align: end;
    align-items: end;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 575px){

    .login-page {

    margin-top: 20vh;
    -ms-flex-align: center;
    align-items: center;
    }
}
    </style>

</head>

<body>
    <div class="back1"></div>
    <div id="particles-js"></div>
    <div class="container">

        <div class="row" style="margin-top:6rem">

            <div class="sbg-red col-sm-6 d-none d-sm-block">

                {{-- login-title --}}
                <div class="login-title" >
                    <p>{{ strtoupper($nama??'') }}</p>
                </div>
                {{-- end login-title --}}

                {{-- login-subtitle --}}
                <div class="login-subtitle">
                    ttt

                </div>
                {{-- ENd login-subtitle --}}

            </div>

            {{-- login-form --}}
            <div class="sbg-yellow col-sm-6 login-form">
                <div class="login-page">
                    <div class="login-box">
                        <div class="card">
                            <div class="card-body login-card-body">
                                <div class="col-12" style="text-align: center">
                                    LOGIN
                                    {{-- <img class="login_img" src="{{ asset('img/login.jpg') }}" alt=""> --}}
                                </div>
                                <p class="login-box-msg"></p>
                                @if (Session::has('error'))
                                    <div class="alert alert-warning alert-dismissible fade show pesan_alert" role="alert">
                                        {{ Session::get('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('postlogin') }}" method="POST" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:40px ">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end login-form --}}
        </div>
    </div>


    <!-- particles.js container -->
    <script src="{{ asset('plugins/particles/particles.js') }}"></script>
    <script src="{{ asset('plugins/particles/app/js/app.js') }}"></script>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>


</body>

</html>
