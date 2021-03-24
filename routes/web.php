<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main;
use App\Http\Controllers\Dispatches;
use App\Http\Controllers\Users;
use App\Http\Controllers\Warnings;



//===============================[ MAIN ]============================================
Route::get('/',[Main::class, 'index'])->name('index');
Route::get('/login', [Main::class, 'login'])->name('login');
Route::post('/login_submit',[Main::class, 'login_submit'])->name('login_submit');
Route::get('/logout',[Main::class, 'logout'])->name('logout');

//===============================[ Users ]===========================================
Route::get('/admin/user',[Users::class, 'user'])->name('user');
Route::post('/admin/create_user',[Users::class, 'create_user'])->name('create_user');
Route::get('/action_user/{id_user}/{action}',[Users::class, 'action_user'])->name('action_user');
Route::post('/password',[Users::class,'alt_user_pwd'])->name('alt_user_pwd');
Route::get('/profile/{user?}',[Users::class, 'user_profile'])->name('user_profile');
//== User (Comum)
Route::get('/home',[Dispatches::class, 'panel'])->name('panel');
Route::post('/request_dispatch',[Dispatches::class, 'request_dispatch'])->name('request_dispatch');
Route::get('/cancel_dispatch',[Dispatches::class, 'cancel_dispatch'])->name('cancel_dispatch');
Route::get('/user_history',[Dispatches::class, 'user_history'])->name('user_history');
Route::post('/edit_profile',[Users::class, 'edit_user_profile'])->name('edit_user_profile');


//===============================[ Warnings ]========================================
Route::get('/status_dispatch/{status_dispatch}',[Warnings::class, 'status_dispatch'])->name('status_dispatch');
Route::post('/warning',[Warnings::class, 'warning'])->name('warning');

//===============================[ Dispatches ]======================================
Route::get('/admin',[Dispatches::class, 'admin'])->name('admin');
Route::get('/action_dispatch/{id_dispatch}/{action}',[Dispatches::class, 'action_dispatch'])->name('action_dispatch');
Route::get('/admin/history', [Dispatches::class, 'history_dispatch'])->name('history_dispatch');
Route::get('/admin/trash', [Dispatches::class, 'trash_dispatch'])->name('trash_dispatch');
Route::get('/admin/trash/clean', [Dispatches::class, 'clean_trash'])->name('clean_trash');
Route::post('/require_dispatch', [Dispatches::class, 'require_dispatch'])->name('require_dispatch');

//============================[Rota de teste]====================================
//Route::get('/mail', [Dispatches::class, 'mail'])->name('mail');
