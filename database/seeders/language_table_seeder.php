<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class language_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('language')->insert(
            ['id' => 1, 'name' => "Türkçe", 'orderby' => 1,],
        );
        DB::table('language')->insert(
            ['id' => 2, 'name' => "İngilizce", 'orderby' => 2,],
        );
    }
}
