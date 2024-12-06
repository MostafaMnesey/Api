<?php

use App\Http\Controllers\api\AddController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\DistrictsController;
use App\Http\Controllers\api\DomainController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

//------------------AuthRoute------------------
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});
//------------------SettingRoute------------------
Route::get('/setting', SettingController::class);

//------------------CityRoute------------------
Route::get('/cities', CityController::class);
//------------------DistrictRoute------------------
Route::get('/districts/{city_id}', DistrictsController::class);
//-------------------MessageRoute------------------
Route::post('/messages', MessageController::class);
//-------------------DomiansRoute------------------
Route::get('/domins', DomainController::class);
//-----------------AddsRoute------------------
Route::prefix('adds')->controller(AddController::class)->group(function () {
    //----------------basic----------------
    Route::get('/', 'index');
    Route::get('/latest', 'latest');
    Route::get('/domain/{id}', 'domain');
    Route::get('/search', 'search');
    //--------------User Api ----------------
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', 'create');
        Route::post('/Update/{Add_id}', 'update');
        Route::delete('/delete/{Add_id}', 'delete');
        Route::get('/myAdds', 'myAdds');
        Route::post('addalbum/{Add_id}', 'addAlbum');
        Route::get('/viewadd', 'viewadd');

    });


});
Route::post('/image', [SettingController::class, 'uploadImage']);

