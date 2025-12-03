<?php

declare(strict_types=1);

namespace Tests\Feature\Appointments;

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Lightit\Appointments\App\Exceptions\InvalidDatesException;
use Lightit\Appointments\App\Exceptions\OverlappingException;
use Lightit\Appointments\App\Exceptions\RelationException;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Actions\ValidateClinicDoctorRelation;
use Lightit\Appointments\Domain\Actions\ValidateDoctorOverlapping;
use Lightit\Appointments\Domain\Actions\ValidateUserOverlapping;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

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
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->addMinutes(30)->toDateTimeString(),
            endTime: now()->addMinutes(90)->toDateTimeString(),
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation()
        );

        try {
            $action->execute($dto, $user);
            $this->fail('Expected OverlappingException was not thrown.');
        } catch (OverlappingException $e) {
            expect($e->getMessage())->toBe('This doctor has an appointment scheduled at this time.');
        }
    });

    it('creates an appointment if the rule pass', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation()
        );

        $appointment = $action->execute(appointmentDto: $dto, user: $user);

        assertDatabaseHas('appointments', ['id' => $appointment->id]);
    });

    it('throw a message error if the end_time is a date after start_time', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->subHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation(),
        );

        try {
            $action->execute($dto, $user);
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
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation(),
        );

        expect(fn (): Appointment => $action->execute($dto, $user))->not()->toThrow(InvalidDatesException::class);
    });

    it('throw an exception if the doctor does not work at the selected clinic', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();

        $dto = new AppointmentDto(
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation(),
        );

        try {
            $action->execute($dto, $user);
            $this->fail('Expected RelationException was not thrown.');
        } catch (RelationException $e) {
            expect($e->getMessage())->tobe('This doctor does not work at this clinic');
        }
    });

    it('does not throw RelationException when the Doctor belong to a Clinic', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation(),
        );

        expect(fn (): \Lightit\Appointments\Domain\Models\Appointment => $action->execute($dto, $user))->not()->toThrow(
            RelationException::class
        );
    });

    it('creates an appointment if all rules pass', function (): void {
        $doctor = DoctorFactory::new()->createOne();
        $user = UserFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $clinic->doctors()->attach($doctor);

        $dto = new AppointmentDto(
            doctorId: $doctor->id,
            clinicId: $clinic->id,
            startTime: now()->toDateTimeString(),
            endTime: now()->addHour()->toDateTimeString()
        );

        $action = new UpsertAppointmentAction(
            new ValidateDoctorOverlapping(),
            new ValidateUserOverlapping(),
            new ValidateClinicDoctorRelation()
        );

        $appointment = $action->execute(appointmentDto: $dto, user: $user);

        assertDatabaseHas('appointments', ['id' => $appointment->id]);
    });
});
