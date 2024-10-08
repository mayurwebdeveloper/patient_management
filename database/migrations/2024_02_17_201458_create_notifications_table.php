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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('name',30)->nullable();
            $table->string('email',30)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('title',50)->nullable();
            $table->text('description')->nullable();
            $table->string('type',10)->nullable();
            $table->boolean('mark')->default(1);
            $table->date('issue_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
