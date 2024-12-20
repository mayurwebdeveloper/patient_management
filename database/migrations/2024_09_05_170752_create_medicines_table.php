<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dosage');
            $table->string('frequency'); // E.g., "Twice a day", "Once a day", etc.
            $table->unsignedBigInteger('prescription_id');
            $table->timestamps();

            // Foreign key to prescriptions
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
