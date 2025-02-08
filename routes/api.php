<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Api\V1\{
    AuthController,
};
Route::prefix("v1")->group(function () {
    //users
    Route::group(['prefix'=> '/user'], function () {
        Route::post('/register', [AuthController::class,'register']);
        Route::post('/login', action: [AuthController::class,'login']);
        Route::middleware([JwtMiddleware::class])->group(function () {
            Route::get('/', [AuthController::class,'getUser']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
    //books
    Route::prefix('books')
    ->middleware([JwtMiddleware::class])
    ->group(base_path('routes/api/v1/books.php'));
});
