<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sopir;
use App\Models\Produk;
use App\Models\Travel;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TravelController extends Controller
{
    function index()
    {
        $data = Travel::all();
        return view('admin.travel.index', compact('data'));
    }
    function create()
    {
        $sopir =  Sopir::whereDoesntHave('travel')->get();
        return view('admin.travel.create', compact('sopir'));
    }
    function edit(Request $req)
    {
        $sopir =  Sopir::all();

        $data = Travel::findOrFail($req->_i);
        return view('admin.travel.edit', compact('data','sopir'));
    }

    function saveData(Request $req)
    {
        $data = $req->only([
            'jenis_mobil',
            'tranmisi',
            'nama',
            'jml_kursi',
            'tahun_mobil',
            'sopir_id',
            'harga',
            'durasi_sewa',
        ]);

        // dd($data);
        $url = '/admin/travel';
        try {
            if ($req->has('_i')) {
                $e = Travel::findOrFail($req->_i);
                $e->update($data);
            } else {
                $e=Travel::create($data);
            }

            if ($req->hasFile('foto_travel')) {
                if ($e->foto_travel) {
                    // Menghapus foto_travel yang ada sebelumnya
                    $e->foto_travel->each->delete();
                }
                $gambar = is_array($req->foto_travel) ? $req->foto_travel : [$req->foto_travel];
                
                // Menghapus foto yang ada jika ada
            
                foreach ($gambar as $index => $foto) {
                    $attachment = new Attachment;
                    $attachment->processFile($foto, ['flag' => 'foto_travel']);
                    if ($attachment->getAttributes()) $e->foto_travel()->save($attachment);
                    
                    // Hanya memproses gambar pertama jika hanya satu gambar yang diunggah
                    if (!is_array($req->foto_travel)) break;
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
        $result = Travel::findOrfail($req->id);
        $result->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
