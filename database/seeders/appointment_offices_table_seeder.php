<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class appointment_offices_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_offices')->insert(
            ['id' => 1, 'name' => "Adana", 'orderby' => 1,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 2, 'name' => "Ankara", 'orderby' => 2,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 3, 'name' => "Antalya", 'orderby' => 3,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 4, 'name' => "Bursa", 'orderby' => 4,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 5, 'name' => "İzmir", 'orderby' => 5,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 6, 'name' => "İstanbul", 'orderby' => 6,],
        );
        DB::table('appointment_offices')->insert(
            ['id' => 7, 'name' => "Londra", 'orderby' => 7,],
        );
    }
}
