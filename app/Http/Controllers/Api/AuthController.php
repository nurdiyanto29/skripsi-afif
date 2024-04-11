<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $e['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $e['name'] =  $user->name;
            $response = [
                'status' => true,
                'message' => 'Login Berhasil',
                'data' => $e

            ];
            return response()->json($response, Response::HTTP_OK);
        } 
        
        else{ 
            $response = [
                'status' => true,
                'message' => 'Unauthorised',
                
            ];
            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        } 
    }
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
                'password' => ['required', 'min:8'],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'hp' => $request->hp,
                'password' => bcrypt($request->password),
                'role' => 'penyewa',
                'status' => 'aktif',
            ]);
    
            $token = $user->createToken('MyApp')->plainTextToken; 
    
            $data = [
                'status' => true,
                'data_penyewa' => $user,
                'token' => $token,
            ];
    
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            // Tangani kesalahan
            $errorMessage = $e->getMessage();
            $errorData = [
                'status' => false,
                'message' => $errorMessage,
            ];
    
            return response()->json($errorData, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'status' => true,
            'message' => 'Logout Berhasil Berhasil',

        ];
        return response()->json($response, Response::HTTP_OK);
    }

}
