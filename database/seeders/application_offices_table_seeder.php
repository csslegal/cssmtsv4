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
        DB::table('application_offices')->insert(['id' => 1, 'name' => "Ankara", 'ip' => '127.0.0.1', 'orderby' => 1,],);
        DB::table('application_offices')->insert(['id' => 2, 'name' => "İstanbul", 'ip' => '78.188.169.67', 'orderby' => 2,],);
        DB::table('application_offices')->insert(['id' => 3, 'name' => "Londra", 'ip' => '176.236.0.98', 'orderby' => 3,],);
    }
}
