<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Lapangan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{

    function index()
    {
        $data = Lapangan::with('lapangan_detail')->get();
        $response = [
            'status' => true,
            'message' => 'Data Lapangan',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $cek_lapangan = Lapangan::count();
        if ($cek_lapangan) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data lapangan sudah tersedia.',
                    'respon code' => Response::HTTP_UNPROCESSABLE_ENTITY
                ]
            );
        }

        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'alamat' => ['required'],
            'email' => ['required', 'email'],
            'hp' => ['required', 'max:20'],
        ]);

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
            $lapangan = Lapangan::create($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Lapangan Berhasil Dibuat',
                'data' => $lapangan

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

        $lapangan = Lapangan::find($id);
        if ($lapangan) {
            $response = [
                'status' => true,
                'data' => $lapangan,
                'Respon code' => 200,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Data Lapangan Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::find($id);
        if (!$lapangan) {
            $response = [
                'status' => false,
                'message' => 'Data Lapangan Dengan id "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'alamat' => ['required'],
            'email' => ['required', 'email'],
            'hp' => ['required', 'max:20'],
        ]);

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
            $lapangan->update($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Lapangan Berhasil diubah',
                'data' => $lapangan

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
        $data = Lapangan::find($id);
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
            'message' => 'Data Lapangan Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
