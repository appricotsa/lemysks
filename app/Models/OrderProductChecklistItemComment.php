<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProductChecklistItemComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_product_checklist_item_comments';
}
