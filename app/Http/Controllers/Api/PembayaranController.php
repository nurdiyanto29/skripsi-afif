<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;



class PembayaranController extends Controller
{
    function index()
    {
        $data = Pembayaran::with('pesanan');
        if (Auth::check() && Auth::user()->role == 'penyewa') {
            $e = $data->whereHas('pesanan', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
        } else {
            $e = $data->get();
        }
        $response = [
            'status' => true,
            'message' => 'Data Pembayaran',
            'data' => $e
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        
        $user = Auth::user();

        // Jika peran pengguna adalah 'penyewa'
        if ($user->role === 'penyewa') {
            // Validasi user_id harus sesuai dengan id pengguna yang sedang masuk
            $validator = Validator::make($request->all(), [
                'pesanan_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($user) {
                        // Periksa apakah pesanan_id ada di tabel pesanan
                        $pesananExists = DB::table('pesanan')
                            ->where('id', $value)
                            ->where('user_id', $user->id) // Hanya mencocokkan pesanan yang dimiliki oleh pengguna saat ini
                            ->exists();
                        if (!$pesananExists) {
                            $fail('Pesanan dengan id ' . $value . ' tidak ditemukan untuk pengguna ini');
                        } else {
                            // Periksa apakah pesanan_id belum terbayar di tabel pembayaran
                            $pesananBelumTerbayar = DB::table('pembayaran')
                                ->where('pesanan_id', $value)
                                ->doesntExist();
            
                            if (!$pesananBelumTerbayar) {
                                $fail('Pesanan sudah terbayar sebelumnya');
                            }
                        }
                    },
                ],
                'nominal' => ['required', 'integer'],
                'bukti_bayar' => ['mimetypes:image/jpeg,image/png', 'max:5000'],
            ]);
        } else {
            // Jika peran pengguna adalah 'admin'
            $validator = Validator::make($request->all(), [
                'pesanan_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Periksa apakah pesanan_id ada di tabel pesanan
                        $pesananExists = DB::table('pesanan')
                            ->where('id', $value)
                            ->exists();
                        if (!$pesananExists) {
                            $fail('Pesanan dengan id ' . $value . ' tidak ditemukan');
                        } else {
                            // Periksa apakah pesanan_id belum terbayar di tabel pembayaran
                            $pesananBelumTerbayar = DB::table('pembayaran')
                                ->where('pesanan_id', $value)
                                ->doesntExist();
            
                            if (!$pesananBelumTerbayar) {
                                $fail('Pesanan sudah terbayar sebelumnya');
                            }
                        }
                    },
                ],
                'nominal' => ['required', 'integer'],
                'bukti_bayar' => ['mimetypes:image/jpeg,image/png', 'max:5000'],
            ]);
        }

        $validator->after(function ($validator) use ($request) {
            $pesanan = Pesanan::findOrFail($request->pesanan_id); // Ambil data pesanan berdasarkan pesanan_id dari request
            $jadwalId = $pesanan->jadwal_id; // Ambil jadwal_id dari pesanan
    
            $jadwal = Jadwal::findOrFail($jadwalId); // Ambil data jadwal berdasarkan jadwal_id dari pesanan
            $hargaJadwal = $jadwal->harga;
    
            if ($request->nominal != $hargaJadwal) {
                $validator->errors()->add('nominal', 'Nominal tidak sesuai dengan harga di jadwal');
            }
        });
        
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            if ($request->hasFile('bukti_bayar')) {
                $imageName = time() . '.' . $request->bukti_bayar->extension();
                $request->bukti_bayar->move(public_path('uploads/bukti_bayar'), $imageName);
            } else {
                // Handle case where file is not provided
                return response()->json([
                    'status' => false,
                    'message' => 'File not provided',
                ], Response::HTTP_BAD_REQUEST);
            }
            $dta = [
                'bukti_bayar' => $imageName,
                'status' => 0,
                'pesanan_id' => $request->pesanan_id,
                'tanggal' => Carbon::now(),
            ];

            $data = Pembayaran::create($dta);
            $response = [
                'status' => true,
                'message' => 'Pembayaran Berhasil Dibuat',
                'data' => $data
            ];
            // dd(1);
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => "Failed" .$e->getMessage()
            ]);
        }
    }

    public function show($id)
    {

        $data = Pembayaran::with('pesanan')->find($id);
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
                'message' => 'Data Pembayaran Tidak Tersedia',
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
                'message' => "Failed" .$e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Pembayaran::find($id);
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
                    'message' => "Failed" .$e->getMessage()
                ]);
            }
        }
        $response = [
            'status' => false,
            'message' => 'Data Pembayaran Dengan id "' . $id . '" Tidak Tersedia',
            'Respon code' => 404,
        ];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
