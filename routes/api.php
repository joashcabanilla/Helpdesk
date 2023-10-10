<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//User Public Route
Route::prefix('v1')->group(
    function (){
        Route::post('/register', [AuthController::class, 'Register']);
        Route::post('/login', [AuthController::class, 'Login']);
        Route::post('/logout', [AuthController::class, 'Logout']);
    }
);

//User Protected Route
Route::prefix('v2')->middleware(['auth:sanctum','abilities:user'])->group(
    function (){
        Route::get('/try', function(){
            return response('try',200);
        });
    }
);
