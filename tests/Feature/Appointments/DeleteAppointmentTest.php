<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Carbon\CarbonImmutable;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Tests\RequestFactories\StoreAppointmentRequestFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\postJson;

describe('appointments', function (): void {
    it('', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);
        $user = UserFactory::new()->createOne();
        actingAs($user);

        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->addMinute()->toDateTimeString(),
            'endTime' => CarbonImmutable::now()->addHour()->toDateTimeString(),
        ]);

        $response = postJson('api/appointments', $appointment);
        $response->assertStatus(201);
        /** @var int $appointmentId */
        $appointmentId = $response->json('data.id');

        $deleteResponse = delete("api/appointments/{$appointmentId}");
        $deleteResponse->assertNoContent();
    });
});
