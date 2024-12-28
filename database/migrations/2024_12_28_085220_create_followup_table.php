<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('speciality_id');
            $table->date('appointment_date')->nullable();
            $table->date('date')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'scheduled'])->default('scheduled');
            $table->timestamps();
            $table->string('patient_name')->nullable();
            $table->string('opd_number');
            $table->string('age', 10)->nullable();
            $table->string('age_month', 10)->nullable();
            $table->string('mobile_number', 15)->nullable();
            $table->string('sex', 15)->nullable();
            $table->string('village', 50)->nullable();
            $table->string('taluka', 50)->nullable();
            $table->date('opd_date')->nullable();
            $table->string('provisional')->nullable();
            $table->double('weight', 8, 2)->nullable();
            $table->double('height', 8, 2)->nullable();
            $table->double('temperature', 8, 2)->nullable();
            $table->integer('pulse')->nullable();
            $table->string('bp')->nullable();
            $table->integer('spo2')->nullable();
            $table->integer('rr')->nullable();
            $table->boolean('paller')->default(false);
            $table->boolean('clubbing')->default(false);
            $table->boolean('cyanosis')->default(false);
            $table->boolean('oedema')->default(false);

            // New fields
           

            // Foreign key constraints
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id')->on('specialities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followup');
    }
};
