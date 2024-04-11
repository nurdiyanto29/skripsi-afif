<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\Controller;
use App\Models\Agenda;
use App\Models\AparaturDesa;
use App\Models\Post;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index()
    {
        $data = [
            'berita' => Post::orderBy('created_at', 'desc')->where('tipe','berita')->take(8)->get(),
            'aparatur_desa' => AparaturDesa::orderBy('created_at', 'desc')->get(),
            'agenda' => Agenda::orderBy('mulai', 'desc')->take(8)->get(),
            'umkm' => Umkm::orderBy('created_at', 'desc')->take(8)->get()
        ];

        return $this->view('frontend.home',$data);
    }


}
