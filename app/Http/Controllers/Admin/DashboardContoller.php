<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use App\Models\Kamling;
use App\Models\Odgj;
use App\Models\Penduduk;
use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardContoller extends Controller
{
    function index(){

        $data = [
            'odgj' => Odgj::count(),
            'umkm' => Umkm::count(),
            'kamling' => Kamling::count(),
            'penduduk' => Penduduk::count(),

        ];
        return view('admin.dashboard',$data);
    }

    function ajax(Request $req){
        $dusun = Dusun::orderBy('nama','ASC')->get();
        if(!$dusun) return set_res('Data kosong!');
       
        $item = [];
        $chart = [
            'labels' => [],
            'backgroundColor' => [],
            'rt' => [],
            'jiwa' => [],
            'lk' => [],
            'pr' => [],
        ];
        $jiwa = $lk = $pr = $rt = 0;
        foreach ($dusun as $key => $val) {
            
            $e = [
                'dusun' => $val->nama,
                'rt' => $val->jumlah_rt,
                'jiwa' => $this->penduduk($val->id,'jiwa'),
                'lk' => $this->penduduk($val->id,'lk'),
                'pr' => $this->penduduk($val->id,'pr'),
            ];

            $rt += $val->jumlah_rt;
            $jiwa += $e['jiwa'];
            $lk += $e['lk'];
            $pr += $e['pr'];

            // chart, jka ada filter selain jiwa tinggal ganti dataset datanya sesuai filter (rt, jiwa, lk, pr)
            $chart['labels'][] = $val->nama;
            $chart['backgroundColor'][] = color_rgb($key);
            $chart['rt'][] = (int)$val->jumlah_rt;
            $chart['jiwa'][] = (int)$e['jiwa'];
            $chart['lk'][] = (int)$e['lk'];
            $chart['pr'][] = (int)$e['pr'];

            $item[] = $e;
        }
        $total = compact('rt','jiwa','lk','pr');
        return set_res('',true, compact('item','total','chart') );

    }

    private function penduduk($dusun_id,$type){
        
        $e = Penduduk::where('dusun_id',$dusun_id);
        if($type == 'lk') $e->where('jk','L');
        if($type == 'pr') $e->where('jk','P');
        return $e->count();
    }

}
