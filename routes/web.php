<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
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

//Landing Page Route
Route::middleware(['guest'])->group(
    function (){
        Route::get('/', [GuestController::class, 'Login'])->name('landing.login');
        Route::get('/register', [GuestController::class, 'Register'])->name('landing.register');
    }
);

//User Page Route
Route::prefix('user')->middleware(['auth','user'])->group(
    function (){
        Route::get('/',function(){
            return dd("user");
        });
    }
);

//Admin Page Route
Route::prefix('admin')->middleware(['auth','admin'])->group(
    function (){
        Route::get('/',function(){
            return dd("admin");
        });
    }
);

//Authentication Route
Route::post('login', [AuthController::class, 'Login']);
Route::post('logout', [AuthController::class, 'Logout']);