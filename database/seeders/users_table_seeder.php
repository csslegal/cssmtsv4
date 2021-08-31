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

        DB::table('users')->insert([
            'name' => "Kullanıcı adı",
            'user_type_id' => "Kullanıcı tipi",
            'email' => "Kullanıcı Emaili",
            'password' => base64_encode('Kullanıcı şifre'),
        ]);
    }
}
