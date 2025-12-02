<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Lightit\Appointments\App\Exceptions\OverlappingException;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Actions\ValidateClinicDoctorRelation;
use Lightit\Appointments\Domain\Actions\ValidateDoctorOverlapping;
use Lightit\Appointments\Domain\Actions\ValidateUserOverlapping;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;

use function Pest\Laravel\assertDatabaseHas;

describe('appointments', function (): void {
    it('throw an exception if the doctor already has an appointment', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $existingAppointment = AppointmentFactory::new()->create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'clinic_id' => $clinic->id,
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);

        $dto = new AppointmentDto(
            doctor_id: $doctor->id,
            user_id: 4,
            clinic_id: $clinic->id,
            startTime: now()->addMinutes(30)->toDateTimeString(),
            endTime: now()->addMinutes(90)->toDateTimeString(),
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation()
        );

        try {
            $action->execute($dto);
            $this->fail('Expected OverlappingException was not thrown.');
        } catch (OverlappingException $e) {
            expect($e->getMessage())->toBe('This doctor has an appointment scheduled at this time.');
        }
    });

    it('creates an appointment if all rules pass', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctor_id: $doctor->id,
            user_id: $user->id,
            clinic_id: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation()
        );

        $appointment = $action->execute($dto);

        assertDatabaseHas('appointments', ['id' => $appointment->id]);
    });
});
