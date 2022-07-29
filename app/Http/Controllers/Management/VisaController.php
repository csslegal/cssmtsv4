<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaController extends Controller
{
    public function get_index()
    {
        $countVisaFileGrades = DB::table('visa_file_grades')->get()->count();
        $countVisaFileGradesUsersType = DB::table('visa_file_grades_users_type')->distinct()->get()->count();
        $countVisaValidity = DB::table('visa_validity')->get()->count();
        $countVisaTypes = DB::table('visa_types')->get()->count();
        $countVisaSubTypes = DB::table('visa_sub_types')->get()->count();
        $countVisaEmailInformationList = DB::table('visa_emails_information')->get()->count();
        $countVisaEmailDocumentList = DB::table('visa_emails_document_list')->get()->count();

        $customerNotes = DB::table('customer_notes')
            ->select([
                "users.name AS u_name",
                'customers.name AS c_name',
                "customer_notes.id",
                "customer_notes.created_at",
                "customer_notes.content"
            ])
            ->leftJoin('customers', 'customers.id', '=', 'customer_notes.customer_id')
            ->leftJoin("users", "users.id", "=", "customer_notes.user_id")
            ->orderByDesc('customer_notes.id')
            ->get();

        $customerEmailLogs = DB::table('email_logs')
            ->select([
                'email_logs.id AS id',
                'users.name AS u_name',
                'customers.name AS c_name',
                'access.name AS a_name',
                'email_logs.subject AS subject',
                'email_logs.created_at AS created_at',
            ])
            ->leftJoin('users', 'users.id', '=', 'email_logs.user_id')
            ->leftJoin('customers', 'customers.id', '=', 'email_logs.customer_id')
            ->leftJoin('access', 'access.id', '=', 'email_logs.access_id')
            ->orderByDesc('email_logs.id')
            ->get();

        return view('management.visa.index')->with(
            [
                'countVisaTypes' => $countVisaTypes,
                'countVisaSubTypes' => $countVisaSubTypes,
                'countFileGrades' => $countVisaFileGrades,
                'countVisaFileGradesUsersType' => $countVisaFileGradesUsersType,
                'countVisaValidity' => $countVisaValidity,
                'countVisaEmailInformationList' => $countVisaEmailInformationList,
                'countVisaEmailDocumentList' => $countVisaEmailDocumentList,
                'customerNotes' => $customerNotes,
                'customerEmailLogs' => $customerEmailLogs,
            ]
        );
    }
    public function get_danisman(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')


            ->where('visa_files.active', '=', 1)
            ->get();
        return view('management.visa.users.danisman')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }

    public function get_uzman(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'advisor_users.name AS advisor_name',
                'expert_users.name AS expert_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS expert_users', 'expert_users.id', '=', 'visa_files.expert_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_GRADES_ID'))
            ->get();
        return view('management.visa.users.uzman')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }

    public function get_tercuman(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'advisor_users.name AS advisor_name',
                'translator_users.name AS translator_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS translator_users', 'translator_users.id', '=', 'visa_files.translator_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATION_GRADES_ID'))
            ->get();
        return view('management.visa.users.tercuman')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }

    public function get_muhasebe(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
            ->where('visa_files.active', '=', 1)

            ->where('visa_files.visa_file_grades_id', '=', env('VISA_PAYMENT_CONFIRM_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_RE_PAYMENT_CONFIRM_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
            ->get();
        return view('management.visa.users.muhasebe')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }
}
