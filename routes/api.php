<?php

declare(strict_types=1);

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Route;
use Lightit\Doctors\App\Controllers\{
    GetDoctorController,
    DeleteDoctorController,
    ListDoctorController,
    StoreDoctorController,
    UpdateDoctorController
};
use Lightit\Users\App\Controllers\{
    GetUserController,
    DeleteUserController,
    ListUserController,
    StoreUserController,
    UpdateUserController
};

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

Route::middleware('auth:sanctum')
    ->get('/me', function (#[CurrentUser] $user) {
        return response()->json([
            'data' => $user,
        ]);
    });


Route::prefix('users')
    ->middleware([])
    ->group(static function (): void {
        Route::get('/', ListUserController::class);
        Route::get('/{user}', GetUserController::class)
            ->withTrashed()
            ->whereNumber('user');
        Route::post('/', StoreUserController::class);
        Route::put('/{user}', UpdateUserController::class)
            ->whereNumber('user');
        Route::delete('/{user}', DeleteUserController::class)
            ->whereNumber('user');
    });

Route::prefix('doctors')
    ->group(static function(): void {
        Route::get('{doctor}', GetDoctorController::class)
            ->withTrashed()
            ->whereNumber('doctor');
        Route::get('/', ListDoctorController::class);
        Route::post('/', StoreUserController::class);
        Route::put('/{doctor}', UpdateDoctorController::class)
            ->whereNumber('doctor');
        Route::delete('/{doctor}', DeleteDoctorController::class)
            ->whereNumber('doctor');
    });
