<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroomingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/sesi', [SessionController::class, 'index']);
// Route::post('/sesi/login', [SessionController::class, 'login']);

// Route::redirect('/', '/login');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/welcome', function () {
//     echo "Anda Berhasil Login";
// })->name('welcome');
// Route::get('/login', [AuthController::class])->name('login');
// Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('Grooming', GroomingController::class);
Route::resource('Penitipan', PenitipanController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminController::class, 'index']);
// Route::get('product', [])

Auth::routes();

Route::redirect('/', '/login');

