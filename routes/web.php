<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Img\ImageController;
use App\Http\Controllers\PageLogin\LoginController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/upload-image', [ImageController::class, 'showForm'])->name('upload.form');
Route::post('/upload-image', [ImageController::class, 'upload'])->name('upload.image');

Route::get('/animation', [ImageController::class, 'Animation'])->name('animation.img');
Route::get('/Login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/Login', [LoginController::class, 'Login'])->name('login.submit');
Route::get('/admin', [App\Http\Controllers\Admin\PageAdminController::class, 'showAdminPage'])->name('admin.page');
//Giao diện Admin
Route::get('/admin/user', function () {
    return view('admin.user');
})->name('admin.user');
Route::get('Login', function () {
    return view('login.login');
})->name('admin.logout');
Route::get('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('admin.account.index');
Route::post('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'storeAccount'])->name('admin.account.store');
// Edit account
Route::get('/admin/account/edit/{id}', [App\Http\Controllers\Admin\AccountController::class, 'editAccount'])->name('admin.account.edit');
Route::post('/admin/account/update/{id}', [App\Http\Controllers\Admin\AccountController::class, 'updateAccount'])->name('admin.account.update');
// Delete account
Route::get('/admin/account/delete/{id}', [App\Http\Controllers\Admin\AccountController::class, 'deleteAccount'])->name('admin.account.delete');




//Page Home
Route::get('/home', [App\Http\Controllers\Page\PageHomeController::class, 'PageHome'])->name('pagehome.pagehome');
