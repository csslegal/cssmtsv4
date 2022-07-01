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
                $sonuc = '<div class="text text-danger">Dosya aşamaları erişimi verilmedi</div>';
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
    public function post_panel_list(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            $kayitlar = DB::table('web_panel_user')->select(['web_panels.name AS name', 'web_groups.name AS g_name'])
                ->join('web_panels', 'web_panels.id', '=', 'web_panel_user.panel_id')
                ->join('web_groups', 'web_groups.id', '=', 'web_panels.group_id')
                ->where('web_panel_user.panel_auth_id', '=', $request->input('id'))
                ->orderBy('web_groups.name')
                ->orderBy('web_panels.name')
                ->get();


            if ($kayitlar->count() == 0) {
                $sonuc = '<div class="text text-danger">İçerik kaydı bulunamadı</div>';
            } else {
                $sonuc = "<div class='text text-primary'>Panel Listesi</div><ol>";
                foreach ($kayitlar as  $kayit) {
                    $sonuc .= "<li> " . $kayit->g_name . ' - ' . $kayit->name . "</li>";
                }
                $sonuc .= "</ol>";
            }
            return  $sonuc;
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function get_customers_list(Request $request)
    {

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('customers')->count();
        $totalRecordswithFilter =
            DB::table('customers')->select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('customers')->orderBy($columnName, $columnSortOrder)
            ->where('customers.name', 'like', '%' . $searchValue . '%')
            ->select('customers.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();



        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $telefon = $record->telefon;
            $email = $record->email;
            $adres = $record->adres;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "telefon" => $telefon,
                "email" => $email,
                "adres" => $adres,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;

        /***$kayitlar = DB::table('customers')->select([
            'customers.id AS id',
            'customers.name AS name',
            'customers.tcno AS tcno',
            'customers.email AS email',
            'customers.telefon AS telefon',
            'customers.adres AS adres',
            'customers.created_at AS created_at',
            'users.name AS u_name',
        ])->leftJoin('users', 'users.id', '=', 'customers.user_id')->orderByDesc('id')->limit(10)->get();**/
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
