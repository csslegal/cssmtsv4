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
        $userAccesses = DB::table('users_access')
            ->select('access.id',)
            ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
            ->where('user_id', '=', $request->session()->get('userId'))
            ->pluck('access.id')->toArray();

        switch ($request->session()->get('userTypeId')) {
            case 2: //danisman
                return view('user.danisman.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 3: //uzman
                return view('user.uzman.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 4: //b. koordinatoor
                return view('user.koordinator.basvuru')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 5: //tercuman
                return view('user.tercuman.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 6: //muhasebe
                return view('user.muhasebe.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 7: //m. koordinatoor
                return view('user.koordinator.musteri')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            case 8: //ofis sorumlusu
                return view('user.ofissorumlusu.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            default:
                return view('general.401');
        }
    }

    public function get_profil(Request $request)
    {
        $kullaniciBilgileri = DB::table('users AS u')
            ->select(
                'u.name AS u_name',
                'u.email AS u_email',
                'u.aktif AS u_aktif',
                'ut.name AS ut_name',
                'bo.name AS bo_name',
                'um.giris',
                'um.cikis'
            )
            ->Join('users_type AS ut', 'ut.id', '=', 'u.user_type_id')
            ->Join('application_offices AS bo', 'bo.id', '=', 'u.application_office_id')
            ->Join('users_mesai AS um', 'um.user_id', '=', 'u.id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->first();

        $erisimIzinleri = DB::table('users AS u')
            ->select('e.name AS name')
            ->rightJoin('users_access AS ue', 'u.id', '=', 'ue.user_id')
            ->rightJoin('access AS e', 'e.id', '=', 'ue.access_id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->get();
        return view('user.profil')->with(
            [
                'kullaniciBilgileri' => $kullaniciBilgileri,
                'erisimIzinleri' => $erisimIzinleri
            ]
        );
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
            if (DB::update(
                'update users set password = ? where id = ?',
                [$password, $request->session()->get('userId')]
            )) {
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

    public function get_duyuru(Request $request)
    {
        $duyuruBilgileri = DB::table('notice AS d')
            ->select(
                'd.id AS d_id',
                'u.name AS u_name',
                'd.aktif AS d_aktif',
                'd.created_at AS d_tarih',
                'd.updated_at AS d_u_tarih'
            )
            ->Join('users AS u', 'u.id', '=', 'd.user_id')
            ->where('d.aktif', '=', 1)
            ->get();
        return view('user.notice.index')->with(
            ['notices' => $duyuruBilgileri]
        );
    }
}
