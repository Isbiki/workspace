<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::group(['middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::get('/forget-password',[AuthController::class,'forgetPassword'])->name('forget_password');
    Route::post('/signin',[AuthController::class,'signin'])->name('signin');
    Route::post('/signup',[AuthController::class,'signup'])->name('signup');
});

Route::group(['middleware'=>'auth'], function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('users/{id}', 'getUser');
        
    });
    
});

Route::resources(['roles'=>RoleController::class]);
Route::get('users', [UserController::class,'index']);
?>