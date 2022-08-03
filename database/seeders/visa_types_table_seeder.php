<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visa_types_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visa_types')->insert(['id' => 1, 'name' => "Ziyaretçi Vizesi", 'orderby' => 1,],);
        DB::table('visa_types')->insert(['id' => 2, 'name' => "Öğrenci Vizesi", 'orderby' => 2,],);
        DB::table('visa_types')->insert(['id' => 3, 'name' => "Çalışma Vizesi", 'orderby' => 3,],);
        DB::table('visa_types')->insert(['id' => 4, 'name' => "İş Kurma / Yatırımcı Vizesi", 'orderby' => 4,],);
        DB::table('visa_types')->insert(['id' => 5, 'name' => "Pasaport Başvurusu", 'orderby' => 5,],);
        DB::table('visa_types')->insert(['id' => 6, 'name' => "Biometrik Kart Yenileme", 'orderby' => 6,],);
        DB::table('visa_types')->insert(['id' => 7, 'name' => "Diğer", 'orderby' => 7,],);
    }
}
