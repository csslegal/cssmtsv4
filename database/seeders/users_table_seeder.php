<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class users_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['id' => 1, 'name' => "Yönetim", 'email' => "yonetim@engin.group", 'password' => "c2VjcmV0MTIz", 'user_type_id' => "1", 'orderby' => 1,],);
    }
}
