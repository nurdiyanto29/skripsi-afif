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
                        class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Register</h3>
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
                            <form>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Email address</label>
                                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Password</label>
                                  <input type="password" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="form-group form-check">
                                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                            {{-- <form method="POST" action="{{ route('post_register') }}" method="POST"
                                class="needs-validation">
                                @csrf
                                <div class="form-group ">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required>

                                </div>
                                <div class="form-group">
                                    <label for="nama">NO Tlp</label>
                                    <input type="number" class="form-control" name="no_tlp" id="no_tlp" required>

                                </div>
                                <div class="form-group first">
                                    <label for="nama">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" required>

                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin:</label><br>
                                    <input type="radio" id="jenis_kelamin_pria" name="jenis_kelamin" value="L" required>
                                    <label for="jenis_kelamin_pria">Pria</label><br>
                                    <input type="radio" id="jenis_kelamin_wanita" name="jenis_kelamin" value="P">
                                    <label for="jenis_kelamin_wanita">Wanita</label><br>
                                </div>
                                
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>

                            

                                <input type="submit" value="Register" class="btn btn-block btn-primary">

                             
                            </form> --}}
                            <div style="text-align: center">
                                <p>Sudah Punya akun?</p> 
                                <a href="/login">Login</a><br><br>
                                <a href="/">
                                    <button class="btn btn-success">Kembali ke halaman awal</button>
                                </a>
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
