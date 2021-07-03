<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\GlobalList;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductChecklist;
use App\Models\OrderProductChecklistItem;
use App\Models\OrderProductChecklistItemComment;
use App\Models\OrderProductChecklistItemImage;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use DB;
use Str;
use Carbon\Carbon;

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
    public function delete_items_comment(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_comment_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    OrderProductChecklistItemComment::where('order_product_checklist_item_comment_guid', $r->order_product_checklist_item_comment_guid)->delete();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function change_item_checked(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $item = OrderProductChecklistItem::where('order_product_checklist_item_guid', $r->order_product_checklist_item_guid)->first();
                    $item->checked = filter_var($r->checked, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
                    $item->update();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function new_order(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('user_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $user = User::where('user_guid', $r->user_guid)->first();
                    if ($user) {
                        $order = new Order();
                        $order->order_guid = Str::uuid();
                        $order->location = $r->location;
                        $order->company_name = $r->company_name;
                        $order->user_guid = $r->user_guid;
                        $order->fullname = $r->fullname;
                        if ($this->checkEmpty($r->eta)) {
                            $explode = explode('T', $r->eta);
                            $eta = $explode[0];
                            $order->eta = Carbon::parse($eta);
                        }
                        if ($this->checkEmpty($r->etd)) {
                            $explode = explode('T', $r->etd);
                            $etd = $explode[0];
                            $order->etd = Carbon::parse($etd);
                        }
                        $order->save();
                        $order = Order::where('order_guid', $order->order_guid)->with('order_product_info.order_product_checklist_info.order_product_checklist_item_info.list_info', 'order_product_info.order_product_checklist_info.order_product_checklist_item_info.images', 'order_product_info.order_product_checklist_info.order_product_checklist_item_info.comments')->first();
                    }
                    return response()->json($order, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function checkEmpty($d)
    {
        if ($d != null && $d != 'null' && $d != '') {
            return true;
        } else {
            return false;
        }
    }
    public function delete_check_list(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $a = OrderProductChecklist::where('order_product_checklist_guid', $r->order_product_checklist_guid)->first();
                    $b = OrderProduct::where('order_product_guid', $a->order_product_guid)->first();
                    $b->quantity = (int)$b->quantity - 1;
                    $b->update();
                    $a->delete();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function delete_items_image(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_image_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    OrderProductChecklistItemImage::where('order_product_checklist_item_image_guid', $r->order_product_checklist_item_image_guid)->delete();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function save_text(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_checklist_item_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $item = OrderProductChecklistItem::where('order_product_checklist_item_guid', $r->order_product_checklist_item_guid)->first();
                    if ($r->has('wrong_input_text')) {
                        $item->wrong_input_text = $r->wrong_input_text;
                    } else if ($r->has('regular_input_text')) {
                        $item->regular_input_text = $r->regular_input_text;
                    } else if ($r->has('right_input_text')) {
                        $item->right_input_text = $r->right_input_text;
                    }
                    $item->update();
                    return response()->json(true, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function save_product_image(Request $r)
    {
        $imageName = Str::uuid() . '-' . pathinfo($r->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
        $r->file('image')->move(storage_path('app/public/images/items'),  $imageName . '.jpg');
        $d['image'] = $imageName . '.jpg';
        return response()->json($d, 200);
    }
    public function save_product(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $quantity = (int)$r->quantity;
                    $order_product = new OrderProduct();
                    $order_product->order_product_guid = Str::uuid();
                    $order_product->order_guid = $r->order_guid;
                    $order_product->image = $r->image;
                    $order_product->title = $r->title;
                    $order_product->quantity = $quantity;
                    $order_product->save();

                    $global_list = GlobalList::get();
                    for ($i = 0; $i < $quantity; $i++) {
                        $order_products_checklists = new OrderProductChecklist();
                        $order_products_checklists->order_product_checklist_guid = Str::uuid();
                        $order_products_checklists->order_product_guid = $order_product->order_product_guid;
                        $order_products_checklists->product_number = $i + 1;
                        $order_products_checklists->save();

                        foreach ($global_list as $key => $l) {
                            $order_products_checklists_items = new OrderProductChecklistItem();
                            $order_products_checklists_items->order_product_checklist_item_guid = Str::uuid();
                            $order_products_checklists_items->order_product_checklist_guid = $order_products_checklists->order_product_checklist_guid;
                            $order_products_checklists_items->list_guid = $l->list_guid;
                            $order_products_checklists_items->save();
                        }
                    }
                    $orderProducts = OrderProduct::where('order_product_guid', $order_product->order_product_guid)->with('order_product_checklist_info.order_product_checklist_item_info.list_info', 'order_product_checklist_info.order_product_checklist_item_info.images', 'order_product_checklist_info.order_product_checklist_item_info.comments')->first();
                    return response()->json($orderProducts, 200);
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
    public function delete_product(Request $r)
    {
        try {
            return DB::transaction(function () use ($r) {
                if (!$r->has('order_product_guid')) {
                    return response()->json('Eksik Bilgi Yollandı.', 400);
                } else {
                    $order_product = OrderProduct::where('order_product_guid', $r->order_product_guid)->first();
                    if ($order_product) {
                        $order_products = OrderProduct::where('order_guid', $order_product->order_guid)->where('order_product_guid', '<>', $r->order_product_guid)->get();
                        $order_product->delete();
                        return response()->json($order_products, 200);
                    }
                }
            });
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
}
