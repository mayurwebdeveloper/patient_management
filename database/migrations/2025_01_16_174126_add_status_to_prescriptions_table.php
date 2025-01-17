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
        $table->enum('status', ['pending', 'transferred', 'completed', 'returned'])->default('pending')->after('pdf_path'); // Replace 'column_name' with the actual column after which you want to add the status field
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
