<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UploadController;  

Route::group(['middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::get('/forget-password',[AuthController::class,'forgetPassword'])->name('forget_password');
    Route::post('/signin',[AuthController::class,'signin'])->name('signin');
    Route::post('/signinWithToken',[AuthController::class,'signinWithToken'])->name('signinWithToken');
    Route::post('/signup',[AuthController::class,'signup'])->name('signup');
});

Route::group(['middleware'=>'auth'], function(){
    // Route::get('users', [UserController::class,'index']);
    
});

Route::resources(['users'=>UserController::class]);
Route::resources(['roles'=>RoleController::class]);
Route::resources(['posts'=>PostController::class]);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::resources(['categories'=>CategoryController::class]);
Route::post('/upload', [UploadController::class, 'upload']); 