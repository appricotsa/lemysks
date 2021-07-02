<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin;
use Auth;
use Log;

class AuthController extends Controller
{
    /**
     * Login Form Sayfası
     */
    public function __construct()
    {
        return $this->middleware('guest:admin')->except('logout');
    }
    public function login()
    {
        return view('backend.auth.login');
    }
    /**
     * Login İşlem Fonksiyonu
     * @param  Request $request Formdan alınan veriler email ve pw
     */
    public function do_login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'pw' => 'required'
        ];
        $validate =  Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            $errors = array(
                "any" => ['Gerekli alanları boş bırakmayınız ve E-Mail adresini düzgün yazınız.']
            );
            return response()->json(['errors' => $errors], 400);
        }
        $checkAdmin = Admin::where('email', $request->email)->first();
        if ($checkAdmin) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->pw], true)) {
                return response()->json(true, 200);
            } else {
                $errors = array(
                    "any" => ['Bilgilerinizi kontrol edip tekrar deneyiniz.']
                );
                return response()->json(['errors' => $errors], 400);
            }
        } else {
            $errors = array(
                "any" => ['Böyle bir kullanıcı sistemde tanımlı değildir.']
            );
            return response()->json(['errors' => $errors], 400);
        }
    }
    /**
     * Admin Çıkış Fonksiyonu
     * @param  Request $request [description]
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect(route('admin.login'));
    }
}
