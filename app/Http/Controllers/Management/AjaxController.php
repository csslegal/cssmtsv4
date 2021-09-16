<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\Sorting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function post_duyuru_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('notice')
                ->select('icerik')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_users_type_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('users_type')
                ->select(['name'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_bilgi_emaili_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('visa_emails_information')
                ->select(['content'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_visa_file_grades_users_type(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            $kayitlar = DB::table('visa_file_grades')
                ->select(
                    'visa_file_grades.name AS name',
                )
                ->join(
                    'visa_file_grades_users_type',
                    'visa_file_grades.id',
                    '=',
                    'visa_file_grades_users_type.visa_file_grade_id'
                )
                ->where('user_type_id', '=', $request->input('id'))
                ->get();
            if ($kayitlar->count() == 0) {
                $sonuc = '<div class="text text-danger">Dosya aşamaları erişimi verilmedi</div>' ;
            } else {
                $sonuc = "<ul>";
                foreach ($kayitlar as  $kayit) {
                    $sonuc .= "<li>" . $kayit->name . "</li>";
                }
                $sonuc .= "</ul>";
            }

            return  $sonuc;
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }
    public function post_evrak_emaili_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('visa_emails_document_list')
                ->select(['content'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_sorting(Request $request)
    {
        /****id ve status gore orderby degeri güncellencek */
        $id = $request->input('id');
        $status = $request->input('status');
        $table = $request->input('table');

        if ($status == 'up') {

            $sirala = new Sorting($table, $id);

            if ($sirala->yukariKontrol()) {
                $sirala->yukari();

                $request->session()
                    ->flash('mesajSuccess', 'Bir üst sıraya alındı');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'En üstte yer alıyor');
            }
        } elseif ($status == 'down') {

            $sirala = new Sorting($table, $id);
            if ($sirala->asagiKontrol()) {
                $sirala->asagi();

                $request->session()
                    ->flash('mesajSuccess', 'Bir alt sıraya alındı');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'En alta yer alıyor');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı istek yapıldı');
        }
    }
}
