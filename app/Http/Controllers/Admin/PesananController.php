<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObjekWisata;
use App\Models\Produk;
use App\Models\Sopir;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;

class PesananController extends Controller
{
    function index()
    {
        $data = Pesanan::all();
        return view('admin.pesanan.index', compact('data'));
    }
    function create()
    {
        $objek =  ObjekWisata::all();
        return view('admin.pesanan.create', compact('objek'));
    }
    function edit(Request $req)
    {

        $data = Pesanan::findOrFail($req->_i);
        return view('admin.pesanan.edit', compact('data'));
    }

    function saveData(Request $req)
    {
        $data = $req->only([
            'tanggal',
            'jam',
            'user_id',
            'jumlah_wisatawan',
            'travel_id',
        ]);

        $url = '/admin/pesanan';
        try {
            if ($req->has('_i')) {
                $e = Pesanan::findOrFail($req->_i);
                $pesanan = $e->update($data);
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
