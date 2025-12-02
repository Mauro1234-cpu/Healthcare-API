<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Lightit\Appointments\App\Exceptions\RelationException;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Actions\ValidateClinicDoctorRelation;
use Lightit\Appointments\Domain\Actions\ValidateDoctorOverlapping;
use Lightit\Appointments\Domain\Actions\ValidateUserOverlapping;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;

use function Pest\Laravel\assertDatabaseHas;

describe('clinic-doctor relation validation', function (): void {
    it('throw an exception if the doctor does not work at the selected clinic', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();

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

        try {
            $action->execute($dto);
            $this->fail('Expecte RelationException was not thrown.');
        } catch (RelationException $e) {
            expect($e->getMessage())->tobe('This doctor does not work at this clinic');
        }
    });

    it('allows creating appointment when the doctor work at the selected clinic', function (): void {
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

        $appointment = $action->execute($dto);

        assertDatabaseHas('appointments', ['id' => $appointment->id]);
    });
});
