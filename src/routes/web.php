<?php

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// ログイン画面
Route::view('/login',  'auth.login')->middleware(['guest'])->name('login');
Route::view('/signin', 'auth.login')->middleware(['guest'])->name('signin');

// 認証処理
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('logout');

// お問い合わせ
Route::get('/', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/back', [ContactController::class, 'back'])->name('contact.back');
Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

//  管理画面
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    Route::delete('/admin/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
