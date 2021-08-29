<?php

use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('admin.index');
});

Route::resource('users', UserController::class );
