<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\MasterdataUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
     
Route::middleware('auth.sanctum')->group( function () {
    Route::resource('articles', ArticleController::class);
});

Route::middleware('auth.sanctum')->group(function () {
    Route::resource('masterdata-users', MasterdataUserController::class);
});

