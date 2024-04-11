<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    function index()
    {

        $data = Pesanan::orderBy('tanggal', 'DESC')->with('user','jadwal','pembayaran','lapangan_detail');
        if (Auth::user()->role == 'penyewa') {
            $e = $data->where('user_id', Auth::user()->id)->get();
        } else {
            $e = $data->get();
        }
        $response = [
            'status' => true,
            'message' => 'Data Pesanan',
            'data' => $e
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jadwal_id' => ['required'],
            'user_id' => ['required'],
            'lapangan_detail_id' => ['required'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $jadwal = $request->input('jadwal_id');
            $lapangan_detail = $request->input('lapangan_detail_id');
            $tanggal = $request->input('tanggal');
            // // Ambil jadwal yang bertabrakan dari database
            $overPesanan = Pesanan::where(function ($query) use ($jadwal, $lapangan_detail, $tanggal) {
                $query->where([
                    'jadwal_id' => $jadwal,
                    'lapangan_detail_id' => $lapangan_detail,
                    'tanggal' => $tanggal,
                ]);
            })->exists();

            // Jika terdapat tumpang tindih dengan jadwal yang sudah ada
            if ($overPesanan)  $validator->errors()->add('Error INFO', 'Jadwal dan Lapangan sudah terboking untuk tanggal yang dipilih');
            if ($tanggal == date('Y-m-d')) {
                $jadwal = Jadwal::find($jadwal);
                if ($jadwal) {
                    $mulai = $jadwal->mulai;
                    $jamSekarang = date('H:i');
                    if ($mulai < $jamSekarang) {
                        $validator->errors()->add('Error INFO', 'Waktu mulai jadwal sudah berlalu');
                    }
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    $validator->errors(),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ]
            );
        }
        try {

            $e = $request->all();

            if (Auth::user()->role == 'penyewa') {
                $e['user_id'] = Auth::user()->id;
            }
            $data = Pesanan::create($e);
            $response = [
                'status' => true,
                'message' => 'Data Pesanan Berhasil Dibuat',
                'data' => $data

            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }


    public function show($id)
    {

        $data = Pesanan::with('jadwal', 'user', 'lapangan_detail');

        if (Auth::user()->role == 'penyewa') {
            $e =$data->where('user_id', Auth::user()->id)->where('id', $id)->first();
        }else $e= $data->find($id);

        if ($data) {
            $response = [
                'status' => true,
                'data' => $e,
                'Respon code' => 200,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Data Pesanan Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $data = Pesanan::find($id);
        if (!$data) {
            $response = [
                'status' => false,
                'message' => 'Data Pesanan Dengan id "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'jadwal_id' => ['required'],
            'user_id' => ['required'],
            'lapangan_detail_id' => ['required'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $jadwal = $request->input('jadwal_id');
            $lapangan_detail = $request->input('lapangan_detail_id');
            $tanggal = $request->input('tanggal');
            $id = $request->id;

            // // Ambil jadwal yang bertabrakan dari database
            $overPesanan = Pesanan::where(function ($query) use ($jadwal, $lapangan_detail, $tanggal, $id) {
                $query->where([
                    'jadwal_id' => $jadwal,
                    'lapangan_detail_id' => $lapangan_detail,
                    'tanggal' => $tanggal,

                ])
                    ->where('id', '!=', $id); // Tambahkan kondisi untuk memeriksa bahwa id tidak sama dengan id yang sedang diupdate
            })->exists();

            // Jika terdapat tumpang tindih dengan jadwal yang sudah ada
            if ($overPesanan)  $validator->errors()->add('Error INFO', 'Jadwal dan Lapangan sudah terboking untuk tanggal yang dipilih');
            if ($tanggal == date('Y-m-d')) {
                $jadwal = Jadwal::find($jadwal);
                if ($jadwal) {
                    $mulai = $jadwal->mulai;
                    $jamSekarang = date('H:i');
                    if ($mulai < $jamSekarang) {
                        $validator->errors()->add('Error INFO', 'Waktu mulai jadwal sudah berlalu');
                    }
                }
            }
        });
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'data' => $validator->errors()

            ];
            return response()->json(
                $response,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $data->update($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Pesanan Berhasil diubah',
                'data' => $data

            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Pesanan::find($id);
        if ($data) {
            try {
                $data->delete();
                $response = [
                    'status' => true,
                    'message' => 'Data Berhasil Di Hapus',

                ];
                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => "Failed" . $e->errorInfo
                ]);
            }
        }
        $response = [
            'status' => false,
            'message' => 'Data Pesanan Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
