<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    function index()
    {

        $data = User::whereRole('penyewa');
        if (Auth::user()->role == 'penyewa') {
            $e = $data->where('id', Auth::user()->id)->first();
        } else {
            $e = $data->get();
        }
        $response = [
            'status' => true,
            'message' => 'Data User (Penyewa)',
            'data' => $e
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => 'required|unique:users,email',
            'hp' => ['required', 'numeric'],
            'password' => ['required'],
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
            $e = [
                'name' => $request->name,
                'email' => $request->email,
                'hp' => $request->hp,
                'password' => bcrypt($request->password),
                'role' => 'penyewa',
            ];
            $data = User::create($e);
            $response = [
                'status' => true,
                'message' => 'Data User (Penyewa) Berhasil Dibuat',
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

        $data = User::find($id);
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
                'message' => 'Data User (Penyewa) Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if (!$data) {
            $response = [
                'status' => false,
                'message' => 'Data User (Penyewa) Dengan id "' . $id . '" Tidak Tersedia',
                'Respon code' => 404,
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => 'required|unique:users,email,' . $data->id,
            'hp' => ['required'],
            'password' => ['required'],
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

            $e = [
                'name' => $request->name,
                'email' => $request->email,
                'hp' => $request->hp,
                'password' => bcrypt($request->password),
                'role' => 'penyewa',
            ];



            $data->update($e);
            $response = [
                'status' => true,
                'message' => 'Data User (Penyewa) Berhasil diubah',
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
        $data = User::find($id);
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
            'message' => 'Data User (Penyewa) Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
