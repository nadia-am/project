<?php

use App\Http\Controllers\Auth\AuthenticateTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Route::get('/', [IndexController::class , 'index']);
Route::get('/', [ProductController::class, 'index']);
Auth::routes();//['verify'=>true]
Route::prefix('auth')->group(function (){
    Route::get('/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.redirect');
    Route::get('/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.callback');

    Route::get('/token', [AuthenticateTokenController::class, 'getToken'])->name('2fa.token');
    Route::post('/token', [AuthenticateTokenController::class, 'postToken'])->name('post.2fa.token');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->prefix('profile')->group( function (){//,'verified'
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::get('/twofactor', [ProfileController::class, 'manageTwoFactor'])->name('profile.2fa');
    Route::post('/twofactor', [ProfileController::class, 'manageTwoFactorPost'])->name('manage.profile.2fa');
    Route::get('/twofactor/phone', [ProfileController::class, 'getPhoneVerify'])->name('phone.verify');
    Route::post('/twofactor/phone', [ProfileController::class, 'postPhoneVerify'])->name('post.phone.verify');
    Route::get('/orders', [OrderController::class, 'index'])->name('profile.orders');
    Route::get('/order/{order}', [OrderController::class, 'single'])->name('profile.order');
    Route::get('/order/{order}/payment', [OrderController::class, 'payment'])->name('profile.order.payment');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.list');
Route::get('/product/{product}', [ProductController::class, 'single'])->name('product.single');
Route::post('/send/comment', [ProfileController::class, 'sendComment'])->name('send.comment');

Route::get('/cart', [CartController::class , 'shoppingCart'])->name('shopping.cart');
Route::post('cart/add/{product}',[CartController::class , 'add'])->name('cart.add');
Route::patch('/cart/quantity/change',[CartController::class , 'quantityUpdate'])->name('quantity.update');
Route::delete('/cart/delete/{product}',[CartController::class , 'deleteCart'])->name('delete.cart');
Route::middleware('auth')->group( function (){
    Route::post('/payment', [PaymentController::class, 'payment'])->name('order.payment');
    Route::get('/payment/callback/{id}', [PaymentController::class, 'callback'])->name('callback.payment');
});
