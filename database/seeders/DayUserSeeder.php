<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DayUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('day_user')->insert([
            'user_id' => 2,
            'day_id'=> 1,
            'days_available' => 15,
        ]);

        DB::table('day_user')->insert([
            'user_id' => 2,
            'day_id'=> 2,
            'days_available' => 10,
        ]);

        DB::table('day_user')->insert([
            'user_id' => 2,
            'day_id'=> 3,
            'days_available' => null,
        ]);
    }
}
