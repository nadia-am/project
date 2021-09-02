<?php

use App\Http\Controllers\Auth\AuthenticateTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Comment;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $product = \App\Models\Product::where('id',2)->first();
    $comments=  sort_comments($product->comments , 0);
    foreach ($comments as $comment){
        print_r($comment['parent_id']);
        if ($comment['childeren']){
            print_r('child');
        }
        print_r('-------------------------------------');
    }dd('fff');
    return view('welcome');
});


Auth::routes(['verify'=>true]);

Route::prefix('auth')->group(function (){
    Route::get('/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.redirect');
    Route::get('/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.callback');

    Route::get('/token', [AuthenticateTokenController::class, 'getToken'])->name('2fa.token');
    Route::post('/token', [AuthenticateTokenController::class, 'postToken'])->name('post.2fa.token');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth','verified'])->prefix('profile')->group( function (){
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::get('/twofactor', [ProfileController::class, 'manageTwoFactor'])->name('profile.2fa');
    Route::post('/twofactor', [ProfileController::class, 'manageTwoFactorPost'])->name('manage.profile.2fa');
    Route::get('/twofactor/phone', [ProfileController::class, 'getPhoneVerify'])->name('phone.verify');
    Route::post('/twofactor/phone', [ProfileController::class, 'postPhoneVerify'])->name('post.phone.verify');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.list');
Route::get('/product/{product}', [ProductController::class, 'single'])->name('product.single');
Route::post('/send/comment', [ProfileController::class, 'sendComment'])->name('send.comment');
