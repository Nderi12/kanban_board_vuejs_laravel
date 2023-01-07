<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['middleware' => ['cors', 'json.response']], function () {
// });
Route::post('login', [ApiAuthController::class, 'login'])->name('login');
Route::post('register', [ApiAuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/card-list', [CardController::class, 'index'])->name('cards-list');
});
Route::resource('columns', ColumnController::class)->only(['index', 'store', 'update', 'destroy']);

Route::resource('cards', CardController::class)->only(['index', 'store', 'update', 'destroy']);


