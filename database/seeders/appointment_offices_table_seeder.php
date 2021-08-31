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
        DB::table('appointment_offices')->insert([

            'name' => "ofis adı",
            'id' => 1,
            'orderby' => 0

        ]);
    }
}
