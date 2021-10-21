<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function get_grades(Request $request, $id)
    {
        $visaIDgradesID = DB::table('customers')
            ->select(['customers.id AS id', 'visa_files.id AS visa_file_id', 'visa_files.visa_file_grades_id AS visa_grades_id',])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        if ($visaIDgradesID == null)
            return 'NOT_FOUND_VISA_FILE';


        if (!$request->session()->has($visaIDgradesID->id . '_visa_id_grades_id')) {
            $request->session()->put($visaIDgradesID->id . '_visa_id_grades_id', $visaIDgradesID->visa_file_id . '_' . $visaIDgradesID->visa_grades_id);
        }

        if ($request->session()->get($visaIDgradesID->id . '_visa_id_grades_id') != $visaIDgradesID->visa_file_id . '_' . $visaIDgradesID->visa_grades_id) {
            $request->session()->forget($visaIDgradesID->id . '_visa_id_grades_id');
            return 1;
        }
    }
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

    public function post_visa_file_log_content(Request $request)
    {
        $getVisaTypes = DB::table('visa_file_logs')
            ->select('content')
            ->where('id', '=', $request->input('id'))
            ->first();

        return ($getVisaTypes);
    }
}
