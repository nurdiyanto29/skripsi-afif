<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Sopir;
use App\Models\Produk;
use App\Models\Travel;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\ObjekWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public $componen = [
        'pesanan_id',
        'tgl_pembayaran',
        'user_id',
        'jumlah_pembayaran',
        'status',
    ];

    function index()
    {
        $data = Pembayaran::all();
        $componen = $this->componen;
        return view('admin.pembayaran.index', compact('data', 'componen'));
    }

    function show(Request $req)
    {
        $data = Pembayaran::findOrFail($req->_i);
        return view('admin.pembayaran.detail', compact('data'));
    }

    function konfirmasi(Request $req)
    {
        // dd($_POST);
        $e = Pembayaran::find($req->pembayaran_id);
        $pesanan = $e->pesanan->update([
            'status' => $req->flag == 'dikonfirmasi' ? 'disetujui' : 'ditolak'
        ]);
        $e->update([
            'status' => $req->flag ?: 'ditolak',
            'admin_id' => Auth::user()->id,
            'tgl_konfirmasi' => Carbon::now(),
        ]);
        return redirect()->to('/admin/pembayaran');
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
