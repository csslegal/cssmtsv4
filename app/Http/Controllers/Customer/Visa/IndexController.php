<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        if ($baseCustomerDetails == null) {
            $request->session()->flash('mesajDanger', 'Müşteri bilgisi bulunamadı');
            return redirect('/musteri/sorgula');
        }

        $visaTypes = DB::table('visa_types')->get();
        $visaFileGrades = DB::table('visa_file_grades')->where('active', '=', 1)->get();

        $visaFileDetail = DB::table('visa_files')
            ->select([
                'visa_files.id AS id',
                'visa_files.status AS status',
                'visa_files.visa_file_grades_id AS visa_file_grades_id',
                'visa_files.temp_grades_id AS temp_grades_id',
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
            ])
            ->leftJoin('users AS user_advisor', 'user_advisor.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS user_translator', 'user_translator.id', '=', 'visa_files.translator_id')
            ->leftJoin('users AS user_expert', 'user_expert.id', '=', 'visa_files.expert_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')

            ->leftJoin('visa_appointments', 'visa_appointments.visa_file_id', '=', 'visa_files.id')

            ->where('visa_files.customer_id', '=', $id)
            ->where('visa_files.active', '=', 1)
            ->first();

        $visaFileGradesLogs = DB::table('visa_file_logs')->select([
            'visa_file_logs.id AS id',
            'visa_file_logs.subject AS subject',
            'visa_file_logs.created_at AS created_at',
            'users.name AS user_name',
        ])
            ->join('visa_files', 'visa_files.id', '=', 'visa_file_logs.visa_file_id')
            ->leftJoin('users', 'users.id', '=', 'visa_file_logs.user_id')
            ->where('visa_files.customer_id', '=', $id)
            ->where('visa_files.active', '=', 1)
            ->orderByDesc('visa_file_logs.id')
            ->get();

        /***dosya acma */
        $visaFileGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', isset($visaFileDetail->visa_file_grades_id) ? $visaFileDetail->visa_file_grades_id : env('VISA_FILE_OPEN_GRADES_ID'))
            ->pluck('user_type_id')->toArray();

        /***arşive taşıma */
        $fileCloseRequestGrade = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_FILE_CLOSE_REQUEST_GRADES_ID'))
            ->pluck('user_type_id')->toArray();

        return view('customer.visa.index')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'visaFileGrades' => $visaFileGrades,
            'visaTypes' => $visaTypes,
            'visaFileDetail' => $visaFileDetail,
            'visaFileGradesLogs' => $visaFileGradesLogs,
            'visaFileGradesPermitted' => [
                /**standart kullanıcı tipinw göre yetkilendirildi mi */
                'permitted' => in_array(
                    $request->session()->get('userTypeId'),
                    $visaFileGradesUserType
                ),
                'grades_url' => isset($visaFileDetail->url) ? $visaFileDetail->url : null,
                'grades_name' => isset($visaFileDetail->grades_name) ? $visaFileDetail->grades_name : null,
                /***dosya kapama işlemlerinin herhangi birinde ise kapama isteği yapılmasını göstermeyi engelleme */
                'fileCloseRequestGradeIds' => isset($visaFileDetail->temp_grades_id) ? true : false,

                /***dosya kapama isteği işlemi için yetkilendirme yapıldı mı */
                'fileCloseRequestGrade' => in_array(
                    $request->session()->get('userTypeId'),
                    $fileCloseRequestGrade
                ),
            ],
        ]);
    }
}
