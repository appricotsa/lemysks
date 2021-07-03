<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProductChecklistItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_product_checklist_items';
    public function list_info()
    {
        return $this->hasOne(GlobalList::class, 'list_guid', 'list_guid');
    }
    public function images()
    {
        return $this->hasMany(OrderProductChecklistItemImage::class, 'order_product_checklist_item_guid', 'order_product_checklist_item_guid');
    }
    public function comments()
    {
        return $this->hasMany(OrderProductChecklistItemComment::class, 'order_product_checklist_item_guid', 'order_product_checklist_item_guid')->orderBy('created_at', 'DESC');
    }
}
