<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('followup', function (Blueprint $table) {
            $table->text('RS')->nullable();
            $table->text('CVS')->nullable();
            $table->text('CNS')->nullable();
            $table->text('PA')->nullable();
            $table->date('LMP')->nullable();
            $table->string('G')->nullable();
            $table->string('P')->nullable();
            $table->string('L')->nullable();
            $table->string('A')->nullable();
            $table->string('age_of_last_child')->nullable();
            $table->string('type_of_last_delivery')->nullable();
            $table->text('personal_ho')->nullable();
            $table->text('past_ho')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('past_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('vitals_general_examination')->nullable();
            $table->text('personal_history')->nullable();
            $table->text('allergic_history')->nullable();
            $table->text('obstetric_history')->nullable();
            $table->text('treatment')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('followup', function (Blueprint $table) {
            $table->dropColumn([
                'RS', 'CVS', 'CNS', 'PA', 'LMP', 'G', 'P', 'L', 'A',
                'age_of_last_child', 'type_of_last_delivery', 'personal_ho',
                'past_ho', 'chief_complaint', 'past_history', 'family_history',
                'vitals_general_examination', 'personal_history', 'allergic_history',
                'obstetric_history', 'treatment', 'remarks',
            ]);
        });
    }
};
