<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    BookController
};
Route::get('/', [BookController::class,'index']);
Route::post('/', [BookController::class,'store']);
Route::put('{id}', [BookController::class,'update']);
Route::delete('{id}', [BookController::class,'destroy']);

