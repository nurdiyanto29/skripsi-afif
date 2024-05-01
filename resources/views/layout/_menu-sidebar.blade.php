<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/004/895/874/small_2x/van-minibus-isolate-on-the-background-ready-to-apply-to-your-design-illustration-free-vector.jpg" alt="Logo" class="brand-image  elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TRAVELGK</span>
    </a>
    <!-- Sidebar -->

    @if (Auth::user()->role == 'admin')
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview"
                    role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="/admin" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @foreach ([
        'travel' => [],
        'sopir' => [],
        'objek_wisata' => [],
        'pesanan' => [],
        'pembayaran' => [],
        // 'kriteria' => [
        //     // 'title' => 'Kriteria Ya', //kosongi saja jika sama dengan kriteria
        //     // 'icon' => 'fas fa-file',
        // ],
        // 'konfigurasi' => [],
        // 'ranking' => [],
        'wisatawan' => [],
    ] as $key => $val)
                        <li class="nav-item">
                            <a href="/admin/{{ $key }}" class="nav-link">
                                <i class="nav-icon {{ isset($val['icon']) ? $val['icon'] : 'far fa-circle' }}"></i>
                                <p>{{ isset($val['title']) ? $val['title'] : str_replace('_', ' ', Str::title($key)) }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <br>
            <!-- /.sidebar-menu -->
        </div>
    @endif
    {{-- @if (Auth::user()->role == 'operator')
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview"
                    role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @foreach ([
        'produk' => [],
        'penjualan' => [],
        // 'kriteria' => [
        //     // 'title' => 'Kriteria Ya', //kosongi saja jika sama dengan kriteria
        //     // 'icon' => 'fas fa-file',
        // ],
        'ranking' => [],
    ] as $key => $val)
                        <li class="nav-item">
                            <a href="/admin/{{ $key }}" class="nav-link">
                                <i class="nav-icon {{ isset($val['icon']) ? $val['icon'] : 'far fa-circle' }}"></i>
                                <p>{{ isset($val['title']) ? $val['title'] : str_replace('_', ' ', Str::title($key)) }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <br>
            <!-- /.sidebar-menu -->
        </div>
    @endif
    <!-- /.sidebar --> --}}
</aside>
