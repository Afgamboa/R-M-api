<?php
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CharacterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::controller(UsersController::class)->group(function () {
        Route::post('/users', 'login');
        Route::post('/users/register', 'register');

        Route::get('/user/profile/{id}', 'profile');
        Route::put('/user/profile/update/{id}', 'updateProfile');



    });

    Route::controller(CharacterController::class)->group(function () {
        Route::post('/character/fav', 'addFavorite');
    });
});