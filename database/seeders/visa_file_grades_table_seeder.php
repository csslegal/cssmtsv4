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
        DB::table('visa_file_grades')->insert(
            ['id' => 7, 'name' => "Dosya açma işlemi", 'active' => 1, 'url' => 'dosya-ac', 'orderby' => 7],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 8, 'name' => "Alınan ödeme kayıt işlemi", 'active' => 1, 'url' => 'alinan-odeme', 'orderby' => 8],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 9, 'name' => "Alınan ödeme onayı işlemi", 'active' => 1, 'url' => 'alinan-odeme-onay', 'orderby' => 9],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 15, 'name' => "Evrak listesi gönderme işlemi", 'active' => 1, 'url' => 'evrak-listesi', 'orderby' => 15],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 16, 'name' => "Evrak hazırlama işlemi", 'active' => 1, 'url' => 'evrak-hazirlama', 'orderby' => 16],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 18, 'name' => "Tercüman atama işlemi", 'active' => 1, 'url' => 'tercuman-yetkilendir', 'orderby' => 18],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 19, 'name' => "Tercüme tamamlama işlemi", 'active' => 1, 'url' => 'tercume-tamamlama', 'orderby' => 19],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 20, 'name' => "Uzman atama işlemi", 'active' => 1, 'url' => 'uzman-yetkilendir', 'orderby' => 20],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 21, 'name' => "Form bilgileri işlemi", 'active' => 1, 'url' => 'form-bilgileri', 'orderby' => 21],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 22, 'name' => "Yapılan ödeme kayıt işlemi", 'active' => 1, 'url' => 'yapilan-odeme', 'orderby' => 22],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 23, 'name' => "Parmak izi işlemi", 'active' => 1, 'url' => 'parmak-izi', 'orderby' => 23],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 24, 'name' => "Fatura kayıt işlemi", 'active' => 1, 'url' => 'fatura-kayit', 'orderby' => 24],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 25, 'name' => "Başvuru sonuç işlemi", 'active' => 1, 'url' => '', 'orderby' => 25],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 26, 'name' => "Teslimat bilgileri işlemi", 'active' => 1, 'url' => 'teslimat-bilgisi', 'orderby' => 26],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 27, 'name' => "Dosya kapandı (Arşiv)", 'active' => 1, 'url' => 'dosya-kapandi', 'orderby' => 27],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 29, 'name' => "Red kararı tercümesi işlemi", 'active' => 1, 'url' => 'red-tercume', 'orderby' => 29],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 30, 'name' => "Randevu erteleme işlemi", 'active' => 1, 'url' => 'randevu-erteleme', 'orderby' => 30],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 31, 'name' => "Yeniden alınan ödeme kayıt işlemi", 'active' => 1, 'url' => 'yeniden-alinan-odeme', 'orderby' => 31],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 32, 'name' => "Yeniden alınan ödeme onay işlemi", 'active' => 1, 'url' => 'yeniden-alinan-odeme-onay', 'orderby' => 32],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 33, 'name' => "Randevu iptal işlemi", 'active' => 1, 'url' => 'randevu-iptali', 'orderby' => 33],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 34, 'name' => "Dosya kapatma işlemi", 'active' => 1, 'url' => 'kapatma', 'orderby' => 34],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 35, 'name' => "Dosya kapatma onayı işlemi", 'active' => 1, 'url' => 'kapatma-onayi', 'orderby' => 35],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 36, 'name' => "İade bilgileri işlemi", 'active' => 1, 'url' => 'iade-bilgileri', 'orderby' => 36],
        );
        DB::table('visa_file_grades')->insert(
            ['id' => 37, 'name' => "İade bilgileri onayı işlemi", 'active' => 1, 'url' => 'iade-bilgileri-onayi', 'orderby' => 37],
            //['id' => , 'name' => "", 'active' => 1, 'url' => '', 'orderby' => ],
        );
    }
}
