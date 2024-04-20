<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObjekWisata;
use App\Models\Produk;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;

class ObjekWisataController extends Controller
{
    function index()
    {
        $data = ObjekWisata::all();
        return view('admin.objek_wisata.index', compact('data'));
    }
    function create()
    {
        return view('admin.objek_wisata.create');
    }
    function edit(Request $req)
    {

        $data = ObjekWisata::findOrFail($req->_i);
        return view('admin.objek_wisata.edit', compact('data'));
    }

    function saveData(Request $req)
    {
        $data = $req->only([
            'nama',
            'lokasi',
            'atraksi',
            'biaya_masuk',
            'deskripsi',
        ]);
        $url = '/admin/objek_wisata';
        try {
            if ($req->has('_i')) {
                $e = ObjekWisata::findOrFail($req->_i);
                $e->update($data);
            } else {
                ObjekWisata::create($data);
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
        $result = ObjekWisata::findOrfail($req->id);
        $result->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
