<?php

use App\Http\Controllers\API\AuditLogController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\IPAddressController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
Route::fallback(function () {
    throw new NotFoundHttpException("Error Processing Request");
})->name('api.fallback.404');

Route::get("/login", function(){
    return "IP Management";
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('api.signin');

Route::middleware('auth:sanctum')->group( function () {
    // logout authenticated  user
    Route::post('/logout',[AuthController::class, 'logout'])->name('api.signout');
    // For IP address Create / Update/ View
    Route::resource('/ip-address', IPAddressController::class, ['except' => ['create','destroy', 'show', 'edit']]);
    // For all audit lists
    Route::get('/auditlogs',[AuditLogController::class, 'index'])->name('api.auditlogs');
});
