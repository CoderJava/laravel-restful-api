<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix' => 'blogs'] {
//     Route::get("/blogs", [Controllers\BlogController::class, 'index'])
// });

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', [Controllers\BlogController::class, 'index']);
    Route::post('/', [Controllers\BlogController::class, 'store']);
    Route::delete('/{id}', [Controllers\BlogController::class, 'destroy'])->where('id', '[a0-9]+');
});
