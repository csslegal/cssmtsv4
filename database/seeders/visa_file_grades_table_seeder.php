<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visa_file_grades_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visa_file_grades')->insert(['id' => 7, 'name' => "Dosya açma işlemi", 'active' => 1, 'url' => 'dosya-ac', 'orderby' => 7],);
        DB::table('visa_file_grades')->insert(['id' => 9, 'name' => "Alınan ödeme onayı işlemi", 'active' => 1, 'url' => 'alinan-odeme-onay', 'orderby' => 9],);
        DB::table('visa_file_grades')->insert(['id' => 16, 'name' => "Evrak hazırlama işlemi", 'active' => 1, 'url' => 'evrak-hazirlama', 'orderby' => 16],);
        DB::table('visa_file_grades')->insert(['id' => 19, 'name' => "Tercüme tamamlama işlemi", 'active' => 1, 'url' => 'tercume-tamamlama', 'orderby' => 19],);
        DB::table('visa_file_grades')->insert(['id' => 21, 'name' => "Form bilgileri işlemi", 'active' => 1, 'url' => 'form-bilgileri', 'orderby' => 21],);
        DB::table('visa_file_grades')->insert(['id' => 23, 'name' => "Parmak izi işlemi", 'active' => 1, 'url' => 'parmak-izi', 'orderby' => 23],);
        DB::table('visa_file_grades')->insert(['id' => 25, 'name' => "Başvuru sonuç işlemi", 'active' => 1, 'url' => '', 'orderby' => 25],);
        DB::table('visa_file_grades')->insert(['id' => 26, 'name' => "Teslimat bilgileri işlemi", 'active' => 1, 'url' => 'teslimat-bilgisi', 'orderby' => 26],);
        DB::table('visa_file_grades')->insert(['id' => 27, 'name' => "Dosya kapandı (Arşiv)", 'active' => 1, 'url' => 'dosya-kapandi', 'orderby' => 27],);

    }
}
