<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>TRAVEL GK</h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="/" class="nav-item nav-link">Home</a>
                <a href="{{url('destinasi')}}" class="nav-item nav-link">Objek Wisata</a>
                <a href="{{url('booking')}}" class="nav-item nav-link">Travel</a>
                <a href="{{url('pesanan')}}" class="nav-item nav-link">Pesanan Saya</a>
            </div>
            @if (!Auth::check())
            <a href="/login" class="btn btn-primary rounded-pill py-2 px-4">Login</a>
            
            @else
            <a href="/logout" class="btn btn-danger rounded-pill py-2 px-4">Logout</a>
            @endif
        </div>
    </nav>
</div>