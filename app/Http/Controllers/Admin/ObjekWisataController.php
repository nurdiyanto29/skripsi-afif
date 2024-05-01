<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sopir;
use App\Models\Produk;
use App\Models\Attachment;
use App\Models\ObjekWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ObjekWisataController extends Controller
{
    public $componen = [
        'nama',
        'lokasi',
        'biaya_masuk',
        'atraksi',
        'deskripsi',
    ];

    function index()
    {
        $data = ObjekWisata::all();
        $componen = $this->componen;
        return view('admin.objek_wisata.index', compact('data','componen'));
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
        $data = $req->only($this->componen);
        $url = '/admin/objek_wisata';
        try {
            if ($req->has('_i')) {
                $e = ObjekWisata::findOrFail($req->_i);
                $e->update($data);
            } else {
                ObjekWisata::create($data);
            }

            if ($req->hasFile('foto_objek')) {
                if ($e->foto_objek->count() > 0) $e->foto_objek->delete();
                $gambar = is_array($req->foto_objek) ? $req->foto_objek : [$req->foto_objek];
                
                // Menghapus foto yang ada jika ada
            
                foreach ($gambar as $index => $foto) {
                    $attachment = new Attachment;
                    $attachment->processFile($foto, ['flag' => 'foto_objek']);
                    if ($attachment->getAttributes()) $e->foto_objek()->save($attachment);
                    
                    // Hanya memproses gambar pertama jika hanya satu gambar yang diunggah
                    if (!is_array($req->foto_objek)) break;
                }
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
