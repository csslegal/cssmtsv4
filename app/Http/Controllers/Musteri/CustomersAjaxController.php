<?php

namespace App\Http\Controllers\Musteri;

use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersAjaxController extends Controller
{
    public function post_name_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('name')
            ->where('name', '=', mb_convert_case(
                mb_strtolower($request->get('name')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_telefon_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('telefon')
            ->where('telefon', '=', mb_convert_case(
                mb_strtolower($request->get('telefon')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_email_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('email')
            ->where('email', '=', mb_convert_case(
                mb_strtolower($request->get('email')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_not_goster(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('customer_notes')
                ->select('content')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_email_goster(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('email_logs')
                ->select('content')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }
    public function post_not_sil(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            if (DB::table('customer_notes')
                ->where('id', '=', $request->input('id'))
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla silindi');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silme işlemi tamamlanamadı');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı istek yapıldı');
        }
    }

    public function post_visa_sub_type(Request $request)
    {
        $getVisaTypes = DB::table('visa_sub_types')
            ->where('visa_type_id', '=', $request->input('id'))
            ->get();

        return ($getVisaTypes);
    }
}
