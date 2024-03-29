<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/{slug}-{id}', [BlogController::class, 'show'])->where([
	"id" => "[0-9]+",
	"slug" => "[a-z0-9\-]+"
])->name('show');

Route::get("login", [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'doLogin']);
Route::delete('logout', [AuthController::class, 'logout'])->name('logout')->middleware("auth");


// créer un utilisateur sans passer par DatabaseSeeder
Route::get('create-user/{token}', [AuthController::class, 'createUser']);

Route::prefix("admin")->name('admin.')->middleware('auth')->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::resource('post', PostController::class)->except(['show']);
	Route::resource('category', CategoryController::class)->except(['show']);
});
