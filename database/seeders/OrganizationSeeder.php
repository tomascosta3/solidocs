<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            'business_name' => 'Solido Connecting Solutions',
            'cuit'=> '12-3456789-0',
            'province' => 'Buenos Aires',
            'city' => 'Mercedes',
            'country' => 'Argentina',
            'domain' => 'solidocs.com.ar',
        ]);
    }
}
