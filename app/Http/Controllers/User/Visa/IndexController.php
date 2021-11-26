<?php

namespace App\Http\Controllers\User\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function get_index(Request $request)
    {
        switch ($request->session()->get('userTypeId')) {
            case 4: //b. koordinatoor
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])
                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATOR_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_EXPERT_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_CANCEL_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_CLOSE_CONFIRM_GRADES_ID'))
                    ->get();
                return view('user.koordinator.visa.musteri')->with([
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 7: //m.koordinator
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])
                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATOR_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_EXPERT_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_CANCEL_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_CLOSE_CONFIRM_GRADES_ID'))
                    ->get();
                return view('user.koordinator.visa.basvuru')->with([
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 8: //ofis sorumlusu
                return view('user.ofis-sorumlusu.visa.index')->with([
                    'visaCustomers' => [],
                ]);
                break;
            default:
                return view('general.401');
        }
    }
    public function get_danisman(Request $request)
    {
        if ($request->session()->get('userTypeId') == 8) {

            $userApplicationOfficeId = DB::table('users')
                ->select(['application_office_id'])
                ->where('id', '=', $request->session()->get('userId'))->first();

            $arrayUserIDs = DB::table('users')
                ->select(['id'])
                ->where('application_office_id', '=', $userApplicationOfficeId->application_office_id)
                ->where('user_type_id', '=', 2)->get()->pluck('id')->toArray();

            $visaCustomers = DB::table('customers')
                ->select([
                    'customers.id AS id',
                    'customers.name AS name',
                    'visa_files.id AS visa_file_id',
                    'visa_files.status AS status',
                    'visa_file_grades.name AS visa_file_grades_name',
                    'visa_validity.name AS visa_validity_name',
                    'visa_types.name AS visa_type_name',
                    'visa_sub_types.name AS visa_sub_type_name',
                    'users.name AS u_name',
                ])
                ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')

                ->where('visa_files.active', '=', 1)
                ->whereIn('visa_files.advisor_id', $arrayUserIDs)
                ->get();
        } else {

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
        }
        return view('user.koordinator.visa.danisman')->with([
            'visaCustomers' => $visaCustomers,
        ]);
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
        return view('user.koordinator.visa.uzman')->with([
            'visaCustomers' => $visaCustomers,
        ]);
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
        return view('user.koordinator.visa.tercuman')->with([
            'visaCustomers' => $visaCustomers,
        ]);
    }

    public function get_ofis_sorumlusu(Request $request)
    {
        return view('user.koordinator.visa.ofis-sorumlusu')->with([
            'visaCustomers' => [],
        ]);
    }
}
