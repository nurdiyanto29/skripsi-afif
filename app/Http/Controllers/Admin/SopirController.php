<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sopir;
use App\Models\Produk;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SopirController extends Controller
{
    function index()
    {
        $data = Sopir::all();
        return view('admin.sopir.index', compact('data'));
    }
    function create()
    {
        return view('admin.sopir.create');
    }
    function edit(Request $req)
    {

        $data = Sopir::findOrFail($req->_i);


        // if ($data->foto_sopir->disk_name ?? null) {
        //     $foto = files_folder($data->foto_sopir->created_at, $data->foto_sopir->disk_name);
        // }


        return view('admin.sopir.edit', compact('data'));
    }

    function saveData(Request $req)
    {

        // dd($req->all());
        $data = $req->only(['nama', 'tanggal_lahir', 'jenis_kelamin']);
        $url = '/admin/sopir';
        try {
            if ($req->has('_i')) {
                $e = Sopir::findOrFail($req->_i);
                $e->update($data);
            } else {
                $e=Sopir::create($data);
            }

            if ($req->hasFile('foto_sopir')) {
                if ($e->foto_sopir) $e->foto_sopir->delete();
                $gambar = is_array($req->foto_sopir) ? $req->foto_sopir : [$req->foto_sopir];
                
                // Menghapus foto yang ada jika ada
            
                foreach ($gambar as $index => $foto) {
                    $attachment = new Attachment;
                    $attachment->processFile($foto, ['flag' => 'foto_sopir']);
                    if ($attachment->getAttributes()) $e->foto_sopir()->save($attachment);
                    
                    // Hanya memproses gambar pertama jika hanya satu gambar yang diunggah
                    if (!is_array($req->foto_sopir)) break;
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
        $result = Sopir::findOrfail($req->id);
        $result->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
