<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main;
use App\Http\Controllers\Dispatches;
use App\Http\Controllers\Users;
use App\Http\Controllers\Warnings;



//===============================[ MAIN ]============================================
Route::get('/',[Main::class, 'index'])->name('index');
Route::get('/logout',[Main::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    //== User (Comum)
    Route::get('/home',[Dispatches::class, 'panel'])->name('panel');
    Route::post('/request_dispatch',[Dispatches::class, 'request_dispatch'])->name('request_dispatch');
    Route::get('/cancel_dispatch',[Dispatches::class, 'cancel_dispatch'])->name('cancel_dispatch');
    Route::get('/user_history',[Dispatches::class, 'user_history'])->name('user_history');

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
});


//============================[Rota de teste]====================================
//Route::get('/mail', [Dispatches::class, 'mail'])->name('mail');
