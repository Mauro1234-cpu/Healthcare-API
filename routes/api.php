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

use Lightit\Clinics\App\Controllers\{
    GetClinicController,
    ListClinicController,
    StoreClinicController,
    DeleteClinicController,
    UpdateClinicController
};

use Lightit\Appointments\App\Controllers\ {
    DeleteAppointmentController,
    GetAppointmentController,
    ListAppointmentController,
    StoreAppointmentController,
    UpdateAppointmentController
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
        Route::post('/', StoreDoctorController::class);
        Route::put('/{doctor}', UpdateDoctorController::class)
            ->whereNumber('doctor');
        Route::delete('/{doctor}', DeleteDoctorController::class)
            ->whereNumber('doctor');
    });

Route::prefix('clinics')
    ->group(static function(): void {
        Route::get('/{clinic}', GetClinicController::class)
            ->withTrashed()
            ->whereNumber('clinic');
        Route::get('/', ListClinicController::class);
        Route::post('/', StoreClinicController::class);
        Route::put('/{clinic}', UpdateClinicController::class)
            ->whereNumber('clinic');
        Route::delete('/{clinic}', DeleteClinicController::class)
            ->whereNumber('clinic');
    });

Route::prefix('appointments')
    ->group(static function(): void {
        Route::get('/', ListAppointmentController::class);
        Route::post('/', StoreAppointmentController::class);

        Route::prefix('{appointment}')
            ->whereNumber('appointment')
            ->group(static function(): void {
                Route::get('/', GetAppointmentController::class);
                Route::put('/', UpdateAppointmentController::class);
                Route::delete('/', DeleteAppointmentController::class);
            });
    });


