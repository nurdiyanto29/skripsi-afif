<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Travel;
use App\Models\Pesanan;
use App\Models\Attachment;
use App\Models\Pembayaran;

use App\Models\Permission;
use App\Models\ObjekWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Notifications\ForDeveloper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function index(){

      $objek= ObjekWisata::take(4)->get();
      $travel= Travel::take(4)->get();
      $data = [
        'objek' => $objek,
        'travel' => $travel,
      ];
      return view('wisatawan.index', $data);
    }

    public function destinasi(){

      $objek= ObjekWisata::all();
      $data = [
        'objek' => $objek,
      ];
      return view('wisatawan.destinasi', $data);
    }

    public function destinasi_detail(){

      $objek= ObjekWisata::find(request('objek_id'));
      $data = [
        'objek' => $objek,
      ];
      return view('wisatawan.destinasi_detail', $data);
    }


    public function booking(){

      $objek= ObjekWisata::take(4)->get();
      $travel= Travel::take(4)->get();
      $data = [
        'objek' => $objek,
        'travel' => $travel,
      ];
      return view('wisatawan.booking', $data);
    }

    public function pesan_travel(Request $req)
    {
        $travel= Travel::find($req->_travel_id);
        $objek= ObjekWisata::all();
        $data=[
          'travel' => $travel,
          'objek' => $objek,
        ];

        return view('wisatawan.pesan',$data );
    }

    function buat_pesanan(Request $req){
      // dd($_POST);

      $data =[
        'tanggal' => $req->tanggal,
        'travel_id' => $req->travel_id,
        'user_id' => Auth::user()->id,
        'jam' => $req->jam,
        'jumlah_wisatawan' => $req->jml_orang,
      ];

      $obj = $req->objek_id[0];
      $a = explode(",", $obj);
      $pesanan = Pesanan::create($data);
      $pesanan->objek_wisata()->sync($a);

      // dd('berhasilll');

      return redirect()->to('/pembayaran?pesanan_id=' . $pesanan->id);
    }

    function pembayaran(){
      // dd(request('pesanan_id'));
      $pesanan=Pesanan::find(request('pesanan_id'));
      return view('wisatawan.pembayaran', compact('pesanan'));
    }

    function proses_bayar(Request $req){
      $data =[
        'tgl_pembayaran' => Carbon::now(),
        'user_id' => Auth::user()->id,
        'metode_pembayaran' => 'transfer',
        'jumlah_pembayaran' => $req->jumlah_pembayaran,
        'status' => 'dibayar',
      ];

      $e = Pembayaran::create($data);
      if ($req->hasFile('foto_pembayaran')) {
        // dd(1);
        if ($e->foto_pembayaran) $e->foto_pembayaran->delete();
        $gambar = is_array($req->foto_pembayaran) ? $req->foto_pembayaran : [$req->foto_pembayaran];
        
        // Menghapus foto yang ada jika ada
    
        foreach ($gambar as $index => $foto) {
            $attachment = new Attachment;
            $attachment->processFile($foto, ['flag' => 'foto_pembayaran']);
            if ($attachment->getAttributes()) $e->foto_pembayaran()->save($attachment);
            
            // Hanya memproses gambar pertama jika hanya satu gambar yang diunggah
            if (!is_array($req->foto_pembayaran)) break;
        }
    }

      dd('berhasilll');

      // return redirect()->to('/pembayaran?pesanan_id=' . $pesanan->id);
    }


}
