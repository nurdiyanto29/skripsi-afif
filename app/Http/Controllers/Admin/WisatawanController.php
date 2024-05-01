<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;

class WisatawanController extends Controller
{
    public $componen = [
        'name',
        'email',
        'password',
        'no_tlp',
        'alamat',
        'jenis_kelamin',
        'role',
    ];

    function index()
    {
        $data = User::where('role', 'wisatawan')->get();
        $componen = $this->componen;
        unset($componen[2]); 
        return view('admin.wisatawan.index', compact('data','componen'));
    }
    function create()
    {
        return view('admin.wisatawan.create');
    }
    function edit(Request $req)
    {

        $data = User::findOrFail($req->_i);
        return view('admin.wisatawan.edit', compact('data'));
    }

    function saveData(Request $req)
    {
        $data = $req->only($this->componen);
        $url = '/admin/wisatawan';

        if (!$req->has('password')) $data['password'] = bcrypt('password');
        if (!$req->has('role')) $data['role'] = 'wisatawan';
        try {
            if ($req->has('_i')) {
                $e = User::findOrFail($req->_i);
                $e->update($data);
            } else {
                User::create($data);
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
        $result = User::findOrfail($req->id);
        $result->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
