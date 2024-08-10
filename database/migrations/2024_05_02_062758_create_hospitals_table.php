<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('type',30)->nullable();
            $table->string('sector',30)->nullable();
            $table->text('specialities')->nullable();

            $table->text('image')->nullable();
            $table->text('brochure')->nullable();

            $table->string('name',50)->nullable();
            $table->text('description')->nullable();
            
            $table->string('mo',30)->nullable();
            $table->string('email',30)->nullable();
            $table->text('address')->nullable();

            $table->integer('state_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('subdivision_id')->nullable();

            $table->boolean('is_pmjay')->defaut(0);
            $table->longText('pmjay_description')->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
