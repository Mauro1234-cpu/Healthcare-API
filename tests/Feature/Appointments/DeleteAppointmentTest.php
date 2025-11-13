<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Database\Factories\AppointmentFactory;
use Illuminate\Http\JsonResponse;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('appointments', function (): void {
    /** @see DeleteAppointmentController */
    it('deletes an Appointment and returns a successful response', function (): void {
        $existingAppointment = AppointmentFactory::new()->createOne();
        $response = deleteJson("api/appointments/$existingAppointment->id");
        $response->assertStatus(JsonResponse::HTTP_OK);

        assertDatabaseMissing('appointments', ['id' => $existingAppointment->id]);
    });

    it('returns a 404 response when Appointment is not found', function (): void {
        $nonExistentAppointmentId = 99999;

        deleteJson("api/appointments/$nonExistentAppointmentId")
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    });
});


// describe('users', function (): void {
//     /** @see DeleteUserController */
//     it('deletes a user and returns a successful response', function (): void {
//         $existingUser = UserFactory::new()->createOne();
//         $response = deleteJson("api/users/$existingUser->id");
//         $response->assertStatus(JsonResponse::HTTP_OK);

//         assertDatabaseMissing('users', ['id' => $existingUser->id]);
//     });

//     it('returns a 404 response when user is not found', function (): void {
//         $nonExistentUserId = 99999;

//         deleteJson("api/users/$nonExistentUserId")
//             ->assertStatus(JsonResponse::HTTP_NOT_FOUND);
//     });
// });
