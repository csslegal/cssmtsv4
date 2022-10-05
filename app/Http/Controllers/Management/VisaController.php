<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\TwoDatesBetween;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Days;

class VisaController extends Controller
{
    public function get_index(Request $request)
    {
        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status')) {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $countVisaFileGrades = DB::table('visa_file_grades')->get()->count();
        $countVisaFileGradesUsersType = DB::table('visa_file_grades_users_type')->distinct()->get()->count();
        $countVisaValidity = DB::table('visa_validity')->get()->count();
        $countVisaTypes = DB::table('visa_types')->get()->count();

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

        $twoDatesBetween = new TwoDatesBetween(
            //başlangıc tarihi
            date("Y-m-d", strtotime('-1 year', strtotime(date("Y-m-d")))),
            //bitiş tarihi
            date("Y-m-d", strtotime('+15 day', strtotime(date("Y-m-d"))))
        );

        $visaFileOpenArray = [];
        $visaFileMadeArray = [];
        $visaFileMountArray = [];

        foreach ($twoDatesBetween->mounts() as $mount) {

            $mountExp = explode('-', $mount);
            $openCount = DB::table('visa_files')
                ->whereMonth('visa_files.created_at', $mountExp[1])
                ->whereYear('visa_files.created_at', $mountExp[0])
                ->get()->count();
            $madeCount = DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->whereMonth('visa_application_result.visa_file_close_date', $mountExp[1])
                ->whereYear('visa_application_result.visa_file_close_date', $mountExp[0])
                ->get()->count();
            if ($openCount == 0 && $madeCount == 0) {
                continue;
            }
            array_push($visaFileMountArray, $mount);
            array_push($visaFileOpenArray, $openCount);
            array_push($visaFileMadeArray, $madeCount);
        }

        $visaFilesOpenMadeCount = [
            '[\'' . implode('\',\'', $visaFileMountArray) . '\']',
            '[' . implode(', ', $visaFileOpenArray) . ']',
            '[' . implode(', ', $visaFileMadeArray) . ']',
        ];

        // dd($visaFilesOpenMadeCount);

        $visaFilesGradesCount = DB::table('visa_files')
            ->select([
                'visa_file_grades.name AS visa_file_grades_name',
                DB::raw('count(*) as total')
            ])
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->groupBy('visa_files.visa_file_grades_id')
            ->where('visa_files.active', '=', $cariDurum)

            ->whereDate('visa_files.created_at', '>=', $startDate)
            ->whereDate('visa_files.created_at', '<=', $endDate)

            ->pluck('total', 'visa_file_grades_name')->all();

        $visaFilesApplicationOfficeCount = DB::table('visa_files')
            ->select([
                'application_offices.name AS application_office_name',
                DB::raw('count(*) as total')
            ])
            ->leftJoin('application_offices', 'application_offices.id', '=', 'visa_files.application_office_id')

            ->groupBy('visa_files.application_office_id')
            ->where('visa_files.active', '=', $cariDurum)

            ->whereDate('visa_files.created_at', '>=', $startDate)
            ->whereDate('visa_files.created_at', '<=', $endDate)

            ->pluck('total', 'application_office_name')->all();

        $arrayVisaFilesAdvisorsAnalist = [];
        $arrayVisaFilesExpertsAnalist = [];
        $arrayVisaFilesTranslationsAnalist = [];

        $allAdvisors = DB::table('users')
            ->select(['id', 'name'])->where('active', '=', 1)
            ->where('user_type_id', '=',  env('ADVISOR_USER_TYPE_ID'))
            ->get();

        foreach ($allAdvisors as $allAdvisor) {

            $positiveCount =   DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $negativeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $iadeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            if ($iadeCount == 0 && $negativeCount == 0 && $positiveCount == 0)
                continue;
            array_push($arrayVisaFilesAdvisorsAnalist, array(
                $allAdvisor->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
                $iadeCount == null ? 0 : $iadeCount
            ));
        }

        $allExperts = DB::table('users')
            ->select(['id', 'name'])
            ->where('active', '=', 1)
            ->where('user_type_id', '=',  env('EXPERT_USER_TYPE_ID'))
            ->get();

        foreach ($allExperts as $allExpert) {

            $positiveCount =   DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.expert_id', '=', $allExpert->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $negativeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.expert_id', '=', $allExpert->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $iadeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.expert_id', '=', $allExpert->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            if ($iadeCount == 0 && $negativeCount == 0 && $positiveCount == 0)
                continue;
            array_push($arrayVisaFilesExpertsAnalist, array(
                $allExpert->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
                $iadeCount == null ? 0 : $iadeCount
            ));
        }

        $allTranslations = DB::table('users')
            ->select(['id', 'name'])
            ->where('active', '=', 1)
            ->where('user_type_id', '=',  env('TRANSLATION_USER_TYPE_ID'))
            ->get();

        $allVisaFileCount =  DB::table('visa_files')
            ->join('visa_translations', 'visa_translations.visa_file_id', '=', 'visa_files.id')
            ->where('visa_files.active', '=', $cariDurum)
            ->whereDate('visa_files.created_at', '>=', $startDate)
            ->whereDate('visa_files.created_at', '<=', $endDate)
            ->get()->count();


        foreach ($allTranslations as $allTranslation) {

            $visaFilesTranslation = DB::table('visa_files')
                ->select([
                    DB::raw("COUNT(visa_files.id) as visa_files_count"),
                    DB::raw("SUM(visa_translations.translated_page) as translated_page_count"),
                    DB::raw("SUM(visa_translations.translated_word) as translated_word_count"),
                ])
                ->join('visa_translations', 'visa_translations.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.translator_id', '=', $allTranslation->id)
                ->where('visa_files.active', '=', $cariDurum)

                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->first();

            if ($visaFilesTranslation->visa_files_count == 0)
                continue;
            array_push($arrayVisaFilesTranslationsAnalist, array(
                $allTranslation->name,
                $visaFilesTranslation->visa_files_count == null ? 0 : $visaFilesTranslation->visa_files_count,
                $visaFilesTranslation->translated_page_count == null ? 0 : $visaFilesTranslation->translated_page_count,
                $visaFilesTranslation->translated_word_count == null ? 0 : $visaFilesTranslation->translated_word_count,
            ));
        }
        return view('management.visa.index')->with([
            'countVisaTypes' => $countVisaTypes,
            'countFileGrades' => $countVisaFileGrades,
            'countVisaFileGradesUsersType' => $countVisaFileGradesUsersType,
            'countVisaValidity' => $countVisaValidity,
            'customerNotes' => $customerNotes,

            'visaFilesOpenMadeCount' => $visaFilesOpenMadeCount,
            'visaFilesGradesCount' => $visaFilesGradesCount,
            'visaFilesApplicationOfficeCount' => $visaFilesApplicationOfficeCount,
            'arrayVisaFilesAdvisorsAnalist' => $arrayVisaFilesAdvisorsAnalist,
            'arrayVisaFilesExpertsAnalist' => $arrayVisaFilesExpertsAnalist,
            'arrayVisaFilesTranslationsAnalist' => $arrayVisaFilesTranslationsAnalist,
            'allVisaFileCount' => $allVisaFileCount,
        ]);
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS expert_users', 'expert_users.id', '=', 'visa_files.expert_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_CONTROL_WAIT_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPLICATION_WAIT_GRADES_ID'))
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS translator_users', 'translator_users.id', '=', 'visa_files.translator_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATIONS_WAIT_GRADES_ID'))
            ->get();
        return view('management.visa.users.tercuman')->with([
            'visaCustomers' => $visaCustomers,
        ]);
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
            ->where('visa_files.active', '=', 1)

            ->where('visa_files.visa_file_grades_id', '=', env('VISA_FILE_OPEN_CONFIRM_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_RE_PAYMENT_CONFIRM_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
            ->get();
        return view('management.visa.users.muhasebe')->with([
            'visaCustomers' => $visaCustomers,
        ]);
    }
}
