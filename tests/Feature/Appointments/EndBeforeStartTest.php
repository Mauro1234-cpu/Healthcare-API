<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Lightit\Appointments\App\Exceptions\InvalidDatesException;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Actions\ValidateClinicDoctorRelation;
use Lightit\Appointments\Domain\Actions\ValidateDoctorOverlapping;
use Lightit\Appointments\Domain\Actions\ValidateUserOverlapping;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

describe('appointments', function (): void {
    it('throw a message error if the end_time is a date after start_time', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctor_id: $doctor->id,
            user_id: $user->id,
            clinic_id: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->subHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation(),
        );

        try {
            $action->execute($dto);
            $this->fail('Expected error message was not thrown.');
        } catch (InvalidDatesException $e) {
            expect($e->getMessage())->tobe('The end time field must be a date after start time.');
        }
    });

    it('does not throw a message error if the end time date is after to start time', function (): void {
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
            new ValidateClinicDoctorRelation(),
        );

        expect(fn (): Appointment => $action->execute($dto))->not()->toThrow(InvalidDatesException::class);
    });
});
