<?php

use App\Http\Controllers\Mobile\MobileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('login', [MobileController::class, 'login']);
Route::post('sksInfo', [MobileController::class, 'sks_info']);
Route::post('uploadItemsImage', [MobileController::class, 'upload_items_image']);
Route::post('saveItemsImage', [MobileController::class, 'save_items_image']);
Route::post('saveItemsComment', [MobileController::class, 'save_items_comment']);
Route::post('deleteItemsComment', [MobileController::class, 'delete_items_comment']);
Route::post('saveText', [MobileController::class, 'save_text']);
Route::post('deleteItemsImage', [MobileController::class, 'delete_items_image']);
Route::post('changeItemChecked', [MobileController::class, 'change_item_checked']);
Route::post('deleteCheckList', [MobileController::class, 'delete_check_list']);
Route::post('deleteCheckList', [MobileController::class, 'delete_check_list']);
Route::post('NewOrder', [MobileController::class, 'new_order']);
Route::post('saveProductImage', [MobileController::class, 'save_product_image']);
Route::post('saveProduct', [MobileController::class, 'save_product']);
Route::post('deleteProduct', [MobileController::class, 'delete_product']);
