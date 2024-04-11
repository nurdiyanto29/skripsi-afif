<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Lapangan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\LapanganDetail;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class LapanganDetailController extends Controller
{

    function index()
    {
        $data = LapanganDetail::all();
        $response = [
            'status' => true,
            'message' => 'Data Detail Lapangan',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $lapangan = Lapangan::pluck('id')->first();
        $validator = Validator::make($request->all(), [
            'lapangan_id' => ['required', 'in:'.$lapangan],
            'nama' => 'required|unique:lapangan_detail,nama',
            'deskripsi' => ['nullable'],
           
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
            $data = LapanganDetail::create($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Lapangan Detail Berhasil Dibuat',
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

        $data = LapanganDetail::find($id);
        if ($data) {
            $response = [
                'status' => true,
                'data' => $data,
                'Respon code' => 200,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => 'Data Lapangan Detail dengan id  "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $data = LapanganDetail::find($id);
        if (!$data) {
            $response = [
                'status' => false,
                'message' => 'Data Lapangan Detail Dengan id "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $lapangan = Lapangan::pluck('id')->first();
        $validator = Validator::make($request->all(), [
            'lapangan_id' => ['required', 'in:'.$lapangan],
            'nama' => 'required|unique:lapangan_detail,nama,'.$data->id,
            'deskripsi' => ['nullable'],
           
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
            $data->update($request->all());
            $response = [
                'status' => true,
                'message' => 'Data Lapangan Detail Berhasil diubah',
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
        $data = LapanganDetail::find($id);
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
            'message' => 'Data Lapangan Detail Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
