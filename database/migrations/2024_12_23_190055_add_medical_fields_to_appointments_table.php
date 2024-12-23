<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->float('weight')->nullable()->after('provisional'); // Replace 'existing_column'
            $table->float('height')->nullable()->after('weight');
            $table->float('temperature')->nullable()->after('height');
            $table->integer('pulse')->nullable()->after('temperature');
            $table->string('bp')->nullable()->after('pulse'); // e.g., '120/80'
            $table->integer('spo2')->nullable()->after('bp');
            $table->integer('rr')->nullable()->after('spo2'); // Respiratory rate
            $table->boolean('paller')->default(false)->after('rr');
            $table->boolean('clubbing')->default(false)->after('paller');
            $table->boolean('cyanosis')->default(false)->after('clubbing');
            $table->boolean('oedema')->default(false)->after('cyanosis');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'weight', 
                'height', 
                'temperature', 
                'pulse', 
                'bp', 
                'spo2', 
                'rr', 
                'paller', 
                'clubbing', 
                'cyanosis', 
                'oedema'
            ]);
        });
    }
};
