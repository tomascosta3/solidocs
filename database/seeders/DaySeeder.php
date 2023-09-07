<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('days')->insert([
            'type' => 'Vacaciones',
            'default_amount'=> '15'
        ]);

        DB::table('days')->insert([
            'type' => 'Licencia por maternidad',
            'default_amount'=> '10'
        ]);

        DB::table('days')->insert([
            'type' => 'Licencia por enfermedad',
            'default_amount'=> '20'
        ]);
    }
}
