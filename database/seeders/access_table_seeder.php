<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class access_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access')->insert(
            ['id' => 1, 'name' => "Vize İşlemleri", 'orderby' => 1,],
        );
        DB::table('access')->insert(
            ['id' => 2, 'name' => "Harici Tercüme İşlemleri", 'orderby' => 2,],
        );
        DB::table('access')->insert(
            ['id' => 3, 'name' => "Dil Okulu İşlemleri", 'orderby' => 3,],
        );
        DB::table('access')->insert(
            ['id' => 4, 'name' => "Web İşlemleri", 'orderby' => 4,],
        );
    }
}
