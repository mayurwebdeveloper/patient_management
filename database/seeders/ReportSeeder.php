<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();

        $reports = [
            ['report_name' => 'Hb', 'created_at' => $currentTimestamp],
            ['report_name' => 'TLC', 'created_at' => $currentTimestamp],
            ['report_name' => 'RBC', 'created_at' => $currentTimestamp],
            ['report_name' => 'DLC', 'created_at' => $currentTimestamp],
            ['report_name' => 'Blood Group', 'created_at' => $currentTimestamp],
            ['report_name' => 'B.S. For M.P.', 'created_at' => $currentTimestamp],
            ['report_name' => 'Bile Salt', 'created_at' => $currentTimestamp],
            ['report_name' => 'Bile Pigment', 'created_at' => $currentTimestamp],
            ['report_name' => 'ESR', 'created_at' => $currentTimestamp],
            ['report_name' => 'HIV', 'created_at' => $currentTimestamp],
            ['report_name' => 'HBsAg', 'created_at' => $currentTimestamp],
            ['report_name' => 'VDRL', 'created_at' => $currentTimestamp],
            ['report_name' => 'Widal', 'created_at' => $currentTimestamp],
            ['report_name' => 'FBS', 'created_at' => $currentTimestamp],
            ['report_name' => 'RBS', 'created_at' => $currentTimestamp],
            ['report_name' => 'PPBS', 'created_at' => $currentTimestamp],
            ['report_name' => 'Urine alb', 'created_at' => $currentTimestamp],
            ['report_name' => 'Urine Sugar', 'created_at' => $currentTimestamp],
            ['report_name' => 'UPT', 'created_at' => $currentTimestamp],
            ['report_name' => 'Sputum For AFB', 'created_at' => $currentTimestamp],
            ['report_name' => 'Papsmear/VIAA', 'created_at' => $currentTimestamp],
            ['report_name' => 'Sickle Cell DTT', 'created_at' => $currentTimestamp],
        ];

        DB::table('reports')->insert($reports);
    }
}
