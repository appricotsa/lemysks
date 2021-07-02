<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\OrderProductChecklistItemComment;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use DB;
use Str;

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

            $user = User::where('user_guid', $r->user_guid)->with('order_info.order_product_info.order_product_checklist_info.order_product_checklist_item_info.list_info', 'order_info.order_product_info.order_product_checklist_info.order_product_checklist_item_info.images', 'order_info.order_product_info.order_product_checklist_info.order_product_checklist_item_info.comments')->first();
            return response()->json($user, 200);
        }
    }
    public function upload_items_image(Request $r)
    {
        $imageName = Str::uuid() . '-' . pathinfo($r->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
        $r->file('image')->move(storage_path('app/public/images/items'),  $imageName . '.jpg');
        $d['image'] = $imageName . '.jpg';
        return response()->json($d, 200);
    }

    public function save_items_image(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $image = new OrderProductChecklistItemImage();
                    $image->order_product_checklist_item_image_guid = Str::uuid();
                    $image->order_product_checklist_item_guid = $r->order_product_checklist_item_guid;
                    $image->image = $r->image;
                    $image->save();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function save_items_comment(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $comment = new OrderProductChecklistItemComment();
                    $comment->order_product_checklist_item_comment_guid = Str::uuid();
                    $comment->order_product_checklist_item_guid = $r->order_product_checklist_item_guid;
                    $comment->text = $r->comment;
                    $comment->save();
                    return response()->json($comment, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
}
