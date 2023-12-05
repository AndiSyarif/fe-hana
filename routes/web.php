<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'prosesRegister']);

// Route::get('/dashboard', [DashboardController::class, 'index']);

// Route::middleware(['api.token'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });

Route::group(['middleware' => ['web']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
