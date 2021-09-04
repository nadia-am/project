<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\admin\users\UserController;
use App\Http\Controllers\Admin\users\UserPermissionController;
use App\Http\Controllers\admin\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('admin.index');
});

Route::resource('users', UserController::class );
Route::resource('permissions', PermissionController::class );
Route::resource('roles', RoleController::class );
Route::get('/user/{user}/permissions', [UserPermissionController::class , 'create'] )->name('users.permissions')->middleware('can:stafff-users-permission');
Route::post('/user/{user}/permissions', [UserPermissionController::class , 'store'] )->name('users.permissions.store')->middleware('can:stafff-users-permission');
Route::resource('products',ProductController::class)->except('show');
Route::resource('comments',CommentController::class)->only(['index','destroy','update']);
Route::resource('categories',CategoryController::class)->except('show');
