<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('FileManager.index');
})->name('home');

Route::get('signup', function () {
    if (session('user_id')) {
        return redirect()->back();
    }
    return view('FileManager.signup');
})->name('signup');
Route::post('signup', [UserController::class, 'store'])->name('User.store');
Route::get('login', function () {
    if (session('user_id')) {
        return redirect()->back();
    }
    return view('FileManager.login');
})->name('User.login');
Route::post('login', [UserController::class, 'index'])->name('User.get');
Route::get('dashboard', [FileController::class, 'index'])->name('dashboard.index');
Route::get('dashboard/create', [FileController::class, 'create'])->name('dashboard.create');
Route::post('dashboard/create', [FileController::class, 'store'])->name('dashboard.store');
Route::get('file/share/{url}', [FileController::class, 'share'])->name('share');
