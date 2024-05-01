<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
              $rdrct = 'admin.index';
                return redirect()->route($rdrct);
            }elseif (Auth::user()->role == 'wisatawan') {
              $rdrct = 'wisatawan.index';
                return redirect()->route($rdrct);
            } else {
                Auth::logout();
                return Redirect()->back()->with(
                    [
                        'error' => 'Anda tidak memiliki akses'
                    ]
                );
            }
        } else {
            return Redirect()->back()->with(
                [
                    'error' => 'Email atau Password Salah'
                ]
            );
        }
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('getlogin');
    }

    public function login()
    {
        if (Auth::check()) {
            $rdrct = 'admin.index';
            return redirect()->route($rdrct);
        }
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    public function post_register(Request $req)
    {
        $data =[
            'name'=> $req->nama,
            'email'=> $req->email,
            'no_tlp'=> $req->no_tlp,
            'password'=> bcrypt($req->password),
            'alamat'=> ($req->alamat),
        ];
        User::create($data);
        return redirect()->to('login');
    }

    private function change_password($req)
    {
    }

    public function admin_password_get()
    {
        return view('admin.ubah_password');
    }

    public function admin_password_post(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'password_lama' => ['required', new MatchOldPassword],
                'password_baru' => ['required'],
                'konfirmasi_password' => ['same:password_baru', 'required'],
            ],
            [
                'password_lama.required' => 'password lama wajib diisi',
                'password_baru.required' => 'password baru wajib diisi',
                'konfirmasi_password.required' => 'konfirmasi password wajib diisi',
                'konfirmasi_password.same' => 'konfirmasi password wajib sama dengan password baru',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::find(Auth::user()->id)->update(['password' => Hash::make($request->password_baru)]);

        Auth::logout();
        \Session::flush();
        return Redirect()->route('getlogin')->with(
            [
                'success' => 'Silahkan login ulang dengan password yang baru.'
            ]
        );
    }
}
