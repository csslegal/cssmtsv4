<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{

    public function index(Request $request)
    {
        $managementInformations = DB::table('users')
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

        return view('management.profil.profil')->with(['managementInformations' => $managementInformations,
            'userAccesses' => $userAccesses,
            'userOffices' => $userOffices,
        ]);
    }

    public function store(Request $request)
    {
        $inputKontrol = new InputKontrol();

        $password = base64_encode($inputKontrol->kontrol($request->input('password')));
        $rePassword = base64_encode($inputKontrol->kontrol($request->input('rePassword')));
        $request->validate(['password' => 'required|max:10', 'rePassword' => 'required|max:10',]);

        if ($password == $rePassword) {
            if (DB::table('users')->where('id', '=', $request->session()->get('userId'))->update(['password' => $password,])) {
                $request->session()->flash('mesajSuccess', 'Şifreniz başarıyla değiştirildi');
                return redirect('yonetim/profil');
            } else {
                $request->session()->flash('mesajDanger', 'Şifreniz güncellenirken sorun oluştu');
                return redirect('yonetim/profil');
            }
        } else {
            $request->session()->flash('mesajInfo', 'Girilen şifreler aynı değil');
            return redirect('yonetim/profil');
        }
    }
}
