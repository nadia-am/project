<?php


use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\DiscountController;

Route::post('/discount/check' , [DiscountController::class , 'check'])->name('discount.check');
Route::Delete('/discount/remove' , [DiscountController::class , 'remove'])->name('discount.remove');
