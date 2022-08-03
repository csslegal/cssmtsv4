<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visa_validity_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visa_validity')->insert(['id' => 1, 'name' => "6 Ay", 'orderby' => 1,],);
        DB::table('visa_validity')->insert(['id' => 2, 'name' => "11 Ay", 'orderby' => 2,],);
        DB::table('visa_validity')->insert(['id' => 3, 'name' => "1 Yıl", 'orderby' => 3,],);
        DB::table('visa_validity')->insert(['id' => 4, 'name' => "2 Yıl", 'orderby' => 4,],);
        DB::table('visa_validity')->insert(['id' => 5, 'name' => "2,5 Yıl", 'orderby' => 5,],);
        DB::table('visa_validity')->insert(['id' => 6, 'name' => "3 Yıl", 'orderby' => 6,],);
        DB::table('visa_validity')->insert(['id' => 7, 'name' => "5 Yıl", 'orderby' => 7,],);
        DB::table('visa_validity')->insert(['id' => 8, 'name' => "10 Yıl", 'orderby' => 8,],);
        DB::table('visa_validity')->insert(['id' => 9, 'name' => "Süresiz Oturum", 'orderby' => 9,],);
        DB::table('visa_validity')->insert(['id' => 10, 'name' => "Diğer", 'orderby' => 10,],);
    }
}
