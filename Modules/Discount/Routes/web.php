<?php

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

use Modules\Discount\Http\Controllers\Admin\DiscountController;

Route::prefix('discount')->group(function() {
    Route::get('/', 'DiscountController@index');
});
Route::resource('discounts', DiscountController::class ) ;
