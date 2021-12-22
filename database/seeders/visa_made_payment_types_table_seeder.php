<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visa_made_payment_types_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visa_made_payment_types')->insert(
            ['id' => 2, 'name' => "Konsolosluk Vize Harcı", 'orderby' => 2,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 4, 'name' => "Priority", 'orderby' => 4,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 5, 'name' => "Super Priority", 'orderby' => 5,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 6, 'name' => "Priority Service For Settlement", 'orderby' => 6,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 7, 'name' => "Courier", 'orderby' => 7,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 8, 'name' => "Prime Time Appointment", 'orderby' => 8,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 9, 'name' => "Premium Lounge", 'orderby' => 9,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 10, 'name' => "Hastane Harcı", 'orderby' => 10,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 11, 'name' => "Randevu Ek Ödemesi", 'orderby' => 11,],
        );
        DB::table('visa_made_payment_types')->insert(
            ['id' => 12, 'name' => "Dil Sınavı", 'orderby' => 12,],
        );
    }
}
