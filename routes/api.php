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

Route::prefix('users')
    ->middleware([])
    ->group(static function (): void {
        Route::get('/', ListUserController::class);
        Route::post('/', StoreUserController::class);
        Route::prefix('{user}')
            ->whereNumber('user')
            ->group(static function (): void{
                Route::get('/', GetUserController::class)
                ->withTrashed();
                Route::put('/', UpdateUserController::class);
                Route::delete('/', DeleteUserController::class);
            });
    });

Route::prefix('doctors')
    ->group(static function(): void {
        Route::get('/', ListDoctorController::class);
        Route::post('/', StoreDoctorController::class);

        Route::prefix('{doctor}')
            ->whereNumber('doctor')
            ->group(static function(): void{
                Route::get('/',GetDoctorController::class)
                    ->withTrashed();
                Route::put('/', UpdateDoctorController::class);
                Route::delete('/', DeleteDoctorController::class);
            });
    });

Route::prefix('clinics')
    ->group(static function(): void {
        Route::get('/', ListClinicController::class);
        Route::post('/', StoreClinicController::class);

        Route::prefix('{clinic}')
            ->whereNumber('clinic')
            ->group(static function(): void {
                Route::get('/', GetClinicController::class)
                ->withTrashed();
                Route::put('/', UpdateClinicController::class);
                Route::delete('/', DeleteClinicController::class);
            });
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


