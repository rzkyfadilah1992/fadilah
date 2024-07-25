<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LoginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// route kategori
Route::get('kategori',[KategoriController::class,'index']);
Route::post('kategori',[KategoriController::class,'store']);
Route::get('kategori/{id}',[KategoriController::class,'show']);
Route::put('kategori/{id}',[KategoriController::class,'update']);
Route::delete('kategori/{id}',[KategoriController::class,'destroy']);

//route aktor
Route::resource('aktor', aktorController::class);
//route genre
Route::resource('genre', genreController::class);

//route user
Route::post('login', [LoginController::class,'autenticate']);


//route register
Route::post('register', [LoginController::class,'register']);