<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCalendarController extends Controller
{
    public function index(Request $request)
    {
        $datas = [];
        $jsonDatas = [];

        $userId = isset($request->user_id) ? $request->user_id : null;
        $userTypeId = isset($request->user_type_id) ? $request->user_type_id : null;

        $startDate = isset($request->start) ?  $request->start : date('Y-m-01');
        $endDate = isset($request->start) ? $request->end : date('Y-m-28');

        if ($userTypeId == 1) { //admin

            $datas = DB::table('visa_files')
                ->join('customers', 'customers.id', '=', 'visa_files.customer_id')
                ->join('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')
                ->join('appointment_offices', 'appointment_offices.id', '=', 'visa_files.appointment_office_id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                ->whereDate('visa_appointments.date', '>=', $startDate)
                ->whereDate('visa_appointments.date', '<=', $endDate)
                ->get([
                    'customers.id AS id',
                    'customers.name AS name',
                    'users.name AS advisor_name',
                    'visa_files.active AS active',
                    'visa_appointments.gwf AS gwf',
                    'visa_appointments.date AS date',
                    'visa_appointments.time AS time',
                    'appointment_offices.name AS appointment_office_name',
                ]);
        } elseif ($userTypeId == 2) { //danisman

            $userApplicationOfficeIds = DB::table('users_application_offices')->select('application_office_id')
                ->where('user_id', '=', $request->session()->get('userId'))
                ->pluck('application_office_id')->toArray();

            $datas = DB::table('visa_files')
                ->join('customers', 'customers.id', '=', 'visa_files.customer_id')
                ->join('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')
                ->join('appointment_offices', 'appointment_offices.id', '=', 'visa_files.appointment_office_id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                //->where('visa_files.advisor_id', '=', $userId)
                ->whereDate('visa_appointments.date', '>=', $startDate)
                ->whereDate('visa_appointments.date', '<=', $endDate)
                ->whereIn('visa_files.application_office_id', $userApplicationOfficeIds)
                ->get([
                    'customers.id AS id',
                    'customers.name AS name',
                    'users.name AS advisor_name',
                    'visa_files.active AS active',
                    'visa_appointments.gwf AS gwf',
                    'visa_appointments.date AS date',
                    'visa_appointments.time AS time',
                    'appointment_offices.name AS appointment_office_name',
                ]);
        } elseif ($userTypeId == 3) { //uzman
            $datas = DB::table('visa_files')
                ->join('customers', 'customers.id', '=', 'visa_files.customer_id')
                ->join('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')
                ->join('appointment_offices', 'appointment_offices.id', '=', 'visa_files.appointment_office_id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                ->where('visa_files.expert_id', '=', $userId)
                ->whereDate('visa_appointments.date', '>=', $startDate)
                ->whereDate('visa_appointments.date', '<=', $endDate)
                ->get([
                    'customers.id AS id',
                    'customers.name AS name',
                    'users.name AS advisor_name',
                    'visa_files.active AS active',
                    'visa_appointments.gwf AS gwf',
                    'visa_appointments.date AS date',
                    'visa_appointments.time AS time',
                    'appointment_offices.name AS appointment_office_name',
                ]);
        } elseif ($userTypeId == 5) { //tercüman
            $datas = DB::table('visa_files')
                ->join('customers', 'customers.id', '=', 'visa_files.customer_id')
                ->join('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')
                ->join('appointment_offices', 'appointment_offices.id', '=', 'visa_files.appointment_office_id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                ->where('visa_files.translator_id', '=', $userId)
                ->whereDate('visa_appointments.date', '>=', $startDate)
                ->whereDate('visa_appointments.date', '<=', $endDate)
                ->get([
                    'customers.id AS id',
                    'customers.name AS name',
                    'users.name AS advisor_name',
                    'visa_files.active AS active',
                    'visa_appointments.gwf AS gwf',
                    'visa_appointments.date AS date',
                    'visa_appointments.time AS time',
                    'appointment_offices.name AS appointment_office_name',
                ]);
        } else {
            $datas = [];
        }
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                if ($data->active == 1) {
                    $url = "";
                } else {
                    $url = "/arsiv";
                }
                array_push($jsonDatas, array(
                    'id' => $data->id,
                    'name' => $data->name,
                    'date' => $data->date . 'T' . $data->time . ':00',
                    'title' => $data->name . ' Randevusu',
                    'description' => '<span class="fw-bold">GWF Numarası: </span> ' . $data->gwf
                        . '<br><span class="fw-bold">Danışmanı: </span>  ' . $data->advisor_name
                        . '<br><span class="fw-bold">Randevu Ofisi: </span>  ' . $data->appointment_office_name
                        . '<br><span class="fw-bold">Randevu Tarihi ve Saati: </span> ' . $data->date . ' ' . $data->time
                        . '<br><br>Müşteri sayfasına gitmek için <a href="/musteri/' . $data->id . '/vize' . $url . '">tıklayınız</a>',
                    'backGroundColor' => '#000000',
                    'color' => '#775511',
                    'borderColor' => 'red',
                ));
            }
        } else {
            return json_encode($jsonDatas);
        }
        return json_encode($jsonDatas);
    }
}
