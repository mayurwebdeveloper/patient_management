<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // $table->string('opd_number')->nullable()->after('updated_at');
            // $table->string('patient_name')->nullable()->after('opd_number');
            // $table->string('age', 10)->nullable()->after('patient_name');
            // $table->string('age_month', 10)->nullable()->after('age');
            // $table->string('mobile_number', 15)->nullable()->after('age_month');
            // $table->string('sex', 15)->nullable()->after('mobile_number');
            // $table->string('village', 50)->nullable()->after('sex');
            // $table->string('taluka', 50)->nullable()->after('village');
            // $table->date('opd_date')->nullable()->after('taluka');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'opd_number',
                'patient_name',
                'age',
                'age_month',
                'mobile_number',
                'sex',
                'village',
                'taluka',
                'opd_date',
            ]);
        });
    }
}
