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
        //
        DB::table('users_type')->insert([

            'name' => "Kullanıcı tip adı",
            'id' => "Kullanıcı tip id",
            'orderby' => 0

        ]);

    }
}
