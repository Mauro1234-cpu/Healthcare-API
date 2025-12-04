<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Carbon\CarbonImmutable;
use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Tests\RequestFactories\StoreAppointmentRequestFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function Symfony\Component\Clock\now;

describe('appointments', function (): void {
    it('throw a message error of overlapping if the doctor already has an appointment', function (): void {
        $user = UserFactory::new()->createOne();
        actingAs($user);
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        AppointmentFactory::new()->create([
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => now(),
            'end_time' => CarbonImmutable::now()->addHour(),
        ]);
        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->addMinutes(5),
            'endTime' => CarbonImmutable::now()->addHour(),
        ]);

        $response = postJson('/api/appointments', $appointment);

        $response->assertStatus(409);
        $response->assertJson([
            'error' => [
                'code' => 'APPOINTMENT_OVERLAP',
                'message' => 'This doctor has an appointment scheduled at this time.',
            ],
        ]);
    });

    it('throw a message error if the end time date is before start time', function (): void {
        $user = UserFactory::new()->createOne();
        actingAs($user);
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->toDateTimeString(),
            'endTime' => CarbonImmutable::now()->subHour()->toDateTimeString(),
        ]);

        $response = postJson('/api/appointments', $appointment);

        $response->assertStatus(422);

        $response->assertJson([
            'error' => [
                'code' => 'validation_failed',
                'message' => 'The end time field must be a date after start time.',
                'fields' => [
                    'endTime' => [
                        'The end time field must be a date after start time.',
                    ],
                ],
            ],
        ]);
    });

    it('throw a message error if the start time date is before to the current date', function (): void {
        $user = UserFactory::new()->createOne();
        actingAs($user);
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);


        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->subHour()->toDateTimeString(),
            'endTime' => CarbonImmutable::now()->toDateTimeString(),
        ]);

        $response = postJson('/api/appointments', $appointment);

        $response->assertStatus(422);

        $response->assertJson([
            'error' => [
                'code' => 'validation_failed',
                'message' => 'The start time field must be a date after or equal to now.',
                'fields' => [
                    'startTime' => [
                        'The start time field must be a date after or equal to now.',
                    ],
                ],
            ],
        ]);
    });

    it('throw a message error if the doctor does not work at the selected clinic', function (): void {
        $user = UserFactory::new()->createOne();
        actingAs($user);
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();

        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->addMinute()->toDateTimeString(),
            'endTime' => CarbonImmutable::now()->addHour()->toDateTimeString(),
        ]);

        $response = postJson('/api/appointments', $appointment);

        $response->assertStatus(409);

        $response->assertJson([
            'error' => [
                'code' => 'INVALID_CLINIC_DOCTOR',
                'message' => 'This doctor does not work at this clinic',
            ],
        ]);
    });

    it('creates an appointment if all rules pass', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        actingAs($user);
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $appointment = StoreAppointmentRequestFactory::new()->create([
            'doctorId' => $doctor->id,
            'clinicId' => $clinic->id,
            'startTime' => CarbonImmutable::now()->addMinute()->toDateTimeString(),
            'endTime' => CarbonImmutable::now()->addHour()->toDateTimeString(),
        ]);

        $response = postJson('/api/appointments', $appointment);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'doctor_id',
                'user_id',
                'clinic_id',
                'start_time',
                'end_time',
            ],
        ]);
    });
});
