<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/login", function(){
    return "IP Management";
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('api.signin');

Route::middleware('auth:sanctum')->group( function () {

    Route::post('/logout',[AuthController::class, 'logout'])->name('api.signout');
    // Route::resource('blogs', BlogController::class);
});
