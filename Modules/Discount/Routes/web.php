<?php


use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\DiscountController;

Route::post('/discount/check' , [DiscountController::class , 'check'])->name('discount.check');
