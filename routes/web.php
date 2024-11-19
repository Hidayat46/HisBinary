<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/register',[TaskController::class,'registration'])->name('user.register');
Route::get('/login',[TaskController::class,'login'])->name('user.login');
Route::post('account/registration',[TaskController::class,'processregister'])->name('user.processregister');
Route::post('/account/authenticate',[TaskController::class,'authenticate'])->name('user.authenticate');
Route::get('account/dashboard', [TaskController::class, 'dashboard'])->name('user.dashboard');
Route::post('post/store', [TaskController::class, 'postStore'])->name('post.store');
Route::post('comment/store', [TaskController::class, 'commentStore'])->name('comment.store');

