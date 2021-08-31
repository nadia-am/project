<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\admin\users\UserController;
use App\Http\Controllers\Admin\users\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('admin.index');
});

Route::resource('users', UserController::class );
Route::resource('permissions', PermissionController::class );
Route::resource('roles', RoleController::class );
Route::get('/user/{user}/permissions', [UserPermissionController::class , 'create'] )->name('users.permissions');
Route::post('/user/{user}/permissions', [UserPermissionController::class , 'store'] )->name('users.permissions.store');
