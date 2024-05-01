<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObjekWisata;
use App\Models\Produk;
use App\Models\Sopir;
use App\Models\Pesanan;
use App\Models\Travel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;

class PesananController extends Controller
{
    public $componen = [
        'tanggal',
        'jam',
        'user_id',
        'jumlah_wisatawan',
        'travel_id',
    ];

    function index()
    {
        $data = Pesanan::with('user', 'travel')->get();
        $this->componen[] = 'status';
        $componen = $this->componen;
        array_unshift($componen, 'id');
        // dd($componen);

        return view('admin.pesanan.index', compact('data', 'componen'));
    }
    function create()
    {
        $objek =  ObjekWisata::all();
        return view('admin.pesanan.create', compact('objek'));
    }
    function edit(Request $req)
    {

        $user = User::all();
        $travel = Travel::all();
        $objek = ObjekWisata::all();
        $data = Pesanan::findOrFail($req->_i);
        $objek_terpilih = $data->objek_wisata()->get(); // Menggunakan get() untuk mendapatkan hasil query
        // dd($objek_terpilih);

        return view('admin.pesanan.edit', compact('data','user','travel','objek','objek_terpilih'));
    }
    function selesaikan(Request $req)
    {
        $data = Pesanan::findOrFail($req->_i);
        $data->update([
            'status' => 'selesai'
        ]);
        return redirect()->to('/admin/pesanan');
    }

    function saveData(Request $req)
    {
        $data = $req->only($this->componen);

        $url = '/admin/pesanan';
        try {
            if ($req->has('_i')) {
                $e = Pesanan::findOrFail($req->_i);
                $e->update($data);
                $pesanan = $e; 
            } else {
                $pesanan = Pesanan::create($data);
            }
            // Simpan hubungan dengan pantai
            if ($req->has('objek_wisata_ids')) {
                $pesanan->objek_wisata()->sync($req->input('objek_wisata_ids'));
            }
            return redirect()->to($url)->with('success', 'Data Berhasil Disimpan');
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
    }

    function store(Request $req)
    {
        return $this->saveData($req);
    }

    function update(Request $req)
    {
        return $this->saveData($req);
    }


    public function destroy(Request $req)
    {
        $result = Pesanan::findOrfail($req->id);
        $result->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
