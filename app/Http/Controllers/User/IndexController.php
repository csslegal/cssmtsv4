<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function get_index(Request $request)
    {
        $visaCustomersUsers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
            'visa_types.name AS visa_type_name',
                'users.name AS u_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')

            ->where('visa_files.active', '=', 1);

        $webResults = DB::table('web_panel_auth')->where('user_id', '=', $request->session()->get('userId'))->get();

        if ($webResults->count() > 0) {
            //dd(date("Y-m-d", strtotime($webResults->start_time)) . " " . date("Y-m-d", time()));
            //suanki time başlangıctan buyuk sondan kucuk olamalı ki erişim izni olsun
            $webResultsFirst =  $webResults->first();
            $panelsTimeAccess = (strtotime($webResultsFirst->start_time) <= strtotime(date("Y-m-d", time()))) && (strtotime(date("Y-m-d", time())) <= strtotime($webResultsFirst->and_time));
        } else {
            $panelsTimeAccess = false;
        }
        $userAccesses = DB::table('users_access')->select('access.id',)
            ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
            ->where('user_id', '=', $request->session()->get('userId'))
            ->pluck('access.id')->toArray();

        switch ($request->session()->get('userTypeId')) {
            case 2: //danisman
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();

                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 3: //uzman
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.expert_id', '=', $request->session()->get('userId'))
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_PUTOFF_GRADES_ID'))
                    ->get();

                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;

            case 5: //tercuman
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.translator_id', '=', $request->session()->get('userId'))
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATION_GRADES_ID'))
                    ->get();

                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 6: //muhasebe
                $visaCustomers = $visaCustomersUsers
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_PAYMENT_CONFIRM_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_RE_PAYMENT_CONFIRM_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
                    ->get();

                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 10: //muhendis
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();
                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 11: //yazar
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();
                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 12: //grafiker
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();
                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 13: //editor
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();
                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            case 14: //s.m uzmanı
                $visaCustomers = $visaCustomersUsers
                    //->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();
                return view('user.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                    'webResults' => $webResults,
                    'panelsTimeAccess' => $panelsTimeAccess,
                ]);
                break;
            default:
                return view('general.401');
        }
    }

    public function get_profil(Request $request)
    {
        $userInformations = DB::table('users')
        ->select([
            'users.name',
            'users.email',
            'users.active',
            'users_mesai.giris',
            'users_mesai.cikis',
            'users_type.name AS ut_name',
        ])
            ->leftJoin('users_type', 'users_type.id', '=', 'users.user_type_id')
            ->leftJoin('users_mesai', 'users_mesai.user_id', '=', 'users.id')
            ->where('users.id', '=', $request->session()->get('userId'))->first();

        $userAccesses = DB::table('users')
        ->select(['access.name AS name'])
        ->rightJoin('users_access', 'users.id', '=', 'users_access.user_id')
        ->rightJoin('access', 'access.id', '=', 'users_access.access_id')
        ->where('users.id', '=', $request->session()->get('userId'))->get();

        $userOffices = DB::table('users')
        ->select(['application_offices.name AS name'])
        ->rightJoin('users_application_offices', 'users.id', '=', 'users_application_offices.user_id')
        ->rightJoin('application_offices', 'application_offices.id', '=', 'users_application_offices.application_office_id')
        ->where('users.id', '=', $request->session()->get('userId'))->get();

        return view('user.profil')->with(['userInformations' => $userInformations,
            'userAccesses' => $userAccesses,
            'userOffices' => $userOffices,
        ]);
    }

    public function post_profil(Request $request)
    {
        //her ihtimale harşı güvenlik kontrolu
        $inputKontrol = new InputKontrol();

        $password = base64_encode($inputKontrol->kontrol($request->input('password')));
        $rePassword = base64_encode($inputKontrol->kontrol($request->input('rePassword')));

        $request->validate([
            'password' => 'required|max:10|min:8',
            'rePassword' => 'required|min:8|max:10',
        ]);

        if ($password == $rePassword) {
            if (DB::update('update users set password = ? where id = ?', [$password, $request->session()->get('userId')])) {
                $request->session()->flash('mesajSuccess', 'Şifreniz başarıyla değiştirildi');
                return redirect('kullanici/profil');
            } else {
                $request->session()->flash('mesajDanger', 'Şifreniz güncellenirken sorun oluştu');
                return redirect('kullanici/profil');
            }
        } else {
            $request->session()->flash('mesajInfo', 'Girilen şifreler aynı değil');
            return redirect('kullanici/profil');
        }
    }
}
