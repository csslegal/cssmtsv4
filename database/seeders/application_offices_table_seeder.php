<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class application_offices_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('application_offices')->insert([
            'name' => "ofis id",
            'id' => 1,
            'ip'=>'127.0.0.1',
            'orderby' => 1
        ]);
    }
}
