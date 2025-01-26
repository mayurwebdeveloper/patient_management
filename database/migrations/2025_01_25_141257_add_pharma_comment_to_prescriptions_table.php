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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->text('pharma_comment')->nullable()->after('notes'); // Use 'text' for potentially longer comments
        });
    }
    
    public function down()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('pharma_comment');
        });
    }
};
