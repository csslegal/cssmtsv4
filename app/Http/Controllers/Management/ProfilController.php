<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $yonetimBilgileri = DB::table('users AS u')
            ->select(
                'u.name',
                'u.email',
                'u.aktif',
                'ut.name AS ut_name',
                'bo.name AS bo_name',
                'um.giris',
                'um.cikis'
            )
            ->leftJoin('users_type AS ut', 'ut.id', '=', 'u.user_type_id')
            ->leftJoin('users_mesai AS um', 'um.user_id', '=', 'u.id')
            ->leftJoin('application_offices AS bo', 'bo.id', '=', 'u.application_office_id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->first();


        $erisimIzinleri = DB::table('users AS u')
            ->select('e.name AS name')
            ->rightJoin('users_access AS ue', 'u.id', '=', 'ue.user_id')
            ->rightJoin('access AS e', 'e.id', '=', 'ue.access_id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->get();

        return view('management.profil.profil')->with(
            [
                'yonetimBilgileri' => $yonetimBilgileri,
                'erisimIzinleri' => $erisimIzinleri

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //her ihtimale harşı güvenlik kontrolu
        $inputKontrol = new InputKontrol();

        $password = base64_encode($inputKontrol->kontrol($request->input('password')));
        $rePassword = base64_encode($inputKontrol->kontrol($request->input('rePassword')));

        $request->validate([
            'password' => 'required|max:10',
            'rePassword' => 'required|max:10',
        ]);

        if ($password == $rePassword) {
            if (
                DB::table('users')
                ->where('id', '=', $request->session()->get('userId'))
                ->update([
                    'password' => $password,
                ])
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Şifreniz başarıyla değiştirildi');
                return redirect('yonetim/profil');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Şifreniz güncellenirken sorun oluştu');
                return redirect('yonetim/profil');
            }
        } else {
            $request->session()
                ->flash('mesajInfo', 'Girilen şifreler aynı değil');
            return redirect('yonetim/profil');
        }
    }
}
