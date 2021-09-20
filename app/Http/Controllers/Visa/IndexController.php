<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $visaTypes = DB::table('visa_types')->get();
        $language = DB::table('language')->get();

        $visaFileDetail = DB::table('visa_files')
            ->select([
                'visa_files.id AS id',
                'visa_files.status AS status',
                'visa_files.status AS visa_file_grades_id',
                'visa_files.created_at AS created_at',

                'visa_types.name AS visa_type_name',

                'visa_sub_types.name AS visa_sub_type_name',

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
            ])
            ->leftJoin('users AS user_advisor', 'user_advisor.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS user_translator', 'user_translator.id', '=', 'visa_files.translator_id')
            ->leftJoin('users AS user_expert', 'user_expert.id', '=', 'visa_files.expert_id')

            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')

            ->where('visa_files.customer_id', '=', $id)
            ->where('visa_files.active', '=', 1)

            ->first();

        return view('customer.visa.index')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'visaTypes' => $visaTypes,
                    'language' => $language,
                    'visaFileDetail' => $visaFileDetail
                ]
            );
    }
}
