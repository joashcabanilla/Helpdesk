<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OpenController;

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
        Route::post('postlogin', [GuestController::class, 'PostLogin']);
    }
);

//User Page Route
Route::prefix('user')->middleware(['auth','user'])->group(
    function (){
        Route::get('/', [GuestController::class, 'UserPage'])->name('user.index');
    }
);

//Admin Page Route
Route::prefix('admin')->middleware(['auth','admin'])->group(
    function (){
        Route::get('/', [AdminController::class, 'AdminPage'])->name('admin.index');
        Route::get('/ticketboard', [AdminController::class, 'TicketBoard'])->name('admin.ticketboard');
        Route::get('/tickethistory', [AdminController::class, 'TicketHistory'])->name('admin.tickethistory');
        Route::get('/board', [AdminController::class, 'Board'])->name('admin.board');
        Route::get('/department', [AdminController::class, 'Department'])->name('admin.department');
        Route::get('/branch', [AdminController::class, 'Branch'])->name('admin.branch');
        Route::get('/subject', [AdminController::class, 'Subject'])->name('admin.subject');
        Route::get('/admin', [AdminController::class, 'Admin'])->name('admin.admin');
        Route::get('/employee', [AdminController::class, 'Employee'])->name('admin.employee');
        Route::get('/member', [AdminController::class, 'Member'])->name('admin.member');
        Route::get('/account', [AdminController::class, 'ManageAccount'])->name('admin.account');
        Route::get('/report', [AdminController::class, 'Report'])->name('admin.report');
        Route::get('/setting', [AdminController::class, 'Setting'])->name('admin.setting');
    }
);

//logout Route
Route::post('postlogout', [OpenController::class, 'PostLogout']);