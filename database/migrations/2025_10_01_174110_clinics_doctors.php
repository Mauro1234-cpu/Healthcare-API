<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics', 'id')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors', 'id')->cascadeOnDelete();
            $table->boolean('active')->default('false');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_doctor');
    }
};
