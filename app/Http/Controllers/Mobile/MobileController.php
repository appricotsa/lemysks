<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['cors', 'api']);
    }
    public function login(Request $r)
    {
        if (!$r->has('user_name') || !$r->has('password')) {
            return response()->json('Eksik Bilgi Yollandı.', 400);
        } else {

            $user = User::where('user_name', $r->user_name)->first();
            if ($user) {
                $hash_check = Hash::check($r->password, $user->password);
                if ($hash_check) {
                    $guid = $user->user_guid;
                    return response()->json(['user_guid' => $guid], 200);
                } else {
                    return response()->json('Şifre yanlış', 400);
                }
            } else {
                return response()->json('Kullanıcı adı veya şifre yanlış', 400);
            }
        }
    }

    public function sks_info(Request $r)
    {
        if (!$r->has('user_guid')) {
            return response()->json('Eksik Bilgi Yollandı.', 400);
        } else {

            $user = User::where('user_guid', $r->user_guid)->with('order_info.order_product_info.order_product_checklist_info.order_product_checklist_item_info.list_info')->first();
            return response()->json($user, 200);
        }
    }
}
