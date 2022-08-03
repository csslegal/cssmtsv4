<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class users_type_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_type')->insert(['id' => 1, 'name' => "Yönetici", 'orderby' => 1,],);
        DB::table('users_type')->insert(['id' => 2, 'name' => "Danışman", 'orderby' => 2,],);
        DB::table('users_type')->insert(['id' => 3, 'name' => "Uzman", 'orderby' => 3,],);
        DB::table('users_type')->insert(['id' => 5, 'name' => "Tercüman", 'orderby' => 5,],);
        DB::table('users_type')->insert(['id' => 6, 'name' => "Muhasebe", 'orderby' => 6,],);
        DB::table('users_type')->insert(['id' => 10, 'name' => "Bilgisayar Mühendisi", 'orderby' => 10,],);
        DB::table('users_type')->insert(['id' => 11, 'name' => "Metin Yazarı", 'orderby' => 11,],);
        DB::table('users_type')->insert(['id' => 12, 'name' => "Grafiker", 'orderby' => 12,],);
        DB::table('users_type')->insert(['id' => 13, 'name' => "Editor", 'orderby' => 13,],);
        DB::table('users_type')->insert(['id' => 14, 'name' => "Sosyal Medya Uzmanı", 'orderby' => 14,],);
    }
}
