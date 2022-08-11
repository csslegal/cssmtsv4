<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivesController extends Controller
{

    public function index($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        if ($baseCustomerDetails == null) {
            $request->session()->flash('mesajDanger', 'Müşteri bilgisi bulunamadı');
            return redirect('/musteri/sorgula');
        }

        $visaArchives = DB::table('visa_files')
            ->select([
                'visa_files.id AS id',
                'visa_files.status AS status',
                'visa_files.visa_file_grades_id AS visa_file_grades_id',
                'visa_files.created_at AS created_at',

                'visa_file_grades.url AS url',
                'visa_file_grades.name AS grades_name',

            'visa_types.name AS visa_type_name',
                'visa_validity.name AS visa_validity_name',

                'visa_appointments.gwf AS visa_appointments_gwf',
                'visa_appointments.name AS visa_appointments_name',
                'visa_appointments.password AS visa_appointments_password',
                'visa_appointments.date AS visa_appointments_date',
                'visa_appointments.time AS visa_appointments_time',
                'visa_appointments.created_at AS visa_appointments_created_at',

                'user_advisor.name AS advisor_name',
                'user_translator.name AS translator_name',
                'user_expert.name AS expert_name',

                'visa_application_result.visa_result',
            'visa_application_result.visa_start_date',
            'visa_application_result.visa_end_date',
            'visa_application_result.visa_delivery_accepted_date',
                'visa_application_result.visa_refusal_reason',
                'visa_application_result.visa_refusal_date',
            'visa_application_result.visa_refusal_delivery_accepted_date',

                'visa_file_delivery.delivery_method',
                'visa_file_delivery.courier_company',
                'visa_file_delivery.tracking_number',
                'visa_file_delivery.created_at AS visa_file_delivery_created_at',

                'application_offices.name AS application_offices_name',
            'appointment_offices.name AS appointment_offices_name',

                'user_delivery.name AS user_delivery_name',
            ])
            ->leftJoin('users AS user_advisor', 'user_advisor.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS user_translator', 'user_translator.id', '=', 'visa_files.translator_id')
            ->leftJoin('users AS user_expert', 'user_expert.id', '=', 'visa_files.expert_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')
            ->leftJoin('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
            ->leftJoin('visa_file_delivery', 'visa_file_delivery.visa_file_id', '=', 'visa_files.id')
            ->leftJoin('users AS user_delivery', 'user_delivery.id', '=', 'visa_file_delivery.user_id')
            ->leftJoin('application_offices', 'application_offices.id', '=', 'visa_file_delivery.application_office_id')
            ->leftJoin('appointment_offices', 'appointment_offices.id', '=', 'visa_appointments.appointment_office_id')

            ->where('visa_files.customer_id', '=', $id)
            ->where('visa_files.active', '=', 0)

            ->get();

        return view('customer.visa.archives')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'visaArchives' => $visaArchives,
        ]);
    }
}
