<?php

namespace App\Http\Controllers\Api;

use DateTime;
use Exception;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\LapanganDetail;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    function index()
    {

        if (request('tanggal')) {
            $tgl = request('tanggal');
            if (DateTime::createFromFormat('Y-m-d', $tgl) !== false) {
                $pesanan = Pesanan::where('tanggal', $tgl)->get();

                // dd($pesanan);
                $jadwal = Jadwal::all();
                $lap_dtl = LapanganDetail::all();

                $lapanganData = [];

                // Loop melalui semua lapangan detail
                foreach ($lap_dtl as $val) {
                    // Inisialisasi array untuk menyimpan jadwal lapangan pada tanggal tertentu
                    $jadwalLapangan = [];

                    // Loop melalui semua jadwal
                    foreach ($jadwal as $jam) {
                        // Membuat kunci jadwal dengan format "12:00 - 13:00"
                        $jamKey = $jam->mulai . ' - ' . $jam->selesai;

                        $status = 'Tersedia';

                        foreach ($pesanan as $p) {
                            if ($p->jadwal_id == $jam->id && $p->lapangan_detail_id == $val->id) {
                                $status = 'Booked';
                                break;
                            }
                        }
                        $jadwalLapangan[$jamKey] = $status;
                    }
                    $lapanganData[$val->nama] = $jadwalLapangan;
                }
                $response = [
                    'status' => true,
                    'message' => 'Data Jadwal',
                    'data' => $lapanganData
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => [
                            'error' => 'tanggal bukan  merupakan format yang valid (Y-m-d)'
                        ],
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    ]
                );
            }
        }


        $data = Jadwal::all();
        $response = [
            'status' => true,
            'message' => 'Data Jadwal',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mulai' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'selesai' => ['required', 'regex:/^\d{2}:\d{2}$/', 'after:mulai'],
            'harga' => ['required', 'numeric'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $mulai = $request->input('mulai');
            $selesai = $request->input('selesai');

            // Ambil jadwal yang bertabrakan dari database
            $overlapJadwal = Jadwal::where(function ($query) use ($mulai, $selesai) {
                $query->where('mulai', '<', $selesai)
                    ->where('selesai', '>', $mulai);
            })->exists();

            // Jika terdapat tumpang tindih dengan jadwal yang sudah ada
            if ($overlapJadwal)  $validator->errors()->add('overlap', 'Jadwal bertabrakan dengan jadwal yang sudah ada.');
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
            $jadwal = Jadwal::create($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Jadwal Berhasil Dibuat',
                'data' => $jadwal

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

        $jadwal = Jadwal::find($id);
        if ($jadwal) {
            $response = [
                'status' => true,
                'data' => $jadwal,
                'Respon code' => 200,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Data Jadwal Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            $response = [
                'status' => false,
                'message' => 'Data Jadwal Dengan id "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'mulai' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'selesai' => ['required', 'regex:/^\d{2}:\d{2}$/', 'after:mulai'],
            'harga' => ['required', 'numeric'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $mulai = $request->input('mulai');
            $selesai = $request->input('selesai');
            $id = $request->id;

            // Ambil jadwal yang bertabrakan dari database
            $overlapJadwal = Jadwal::where(function ($query) use ($mulai, $selesai, $id) {
                $query->where('mulai', '<', $selesai)
                    ->where('selesai', '>', $mulai)
                    ->where('id', '!=', $id); // Tambahkan kondisi untuk memeriksa bahwa id tidak sama dengan id yang sedang diupdate
            })->exists();
            // Jika terdapat tumpang tindih dengan jadwal yang sudah ada
            if ($overlapJadwal)  $validator->errors()->add('overlap', 'Jadwal bertabrakan dengan jadwal yang sudah ada.');
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
            $jadwal->update($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Jadwal Berhasil diubah',
                'data' => $jadwal

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
        $data = Jadwal::find($id);
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
            'message' => 'Data Jadwal Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
