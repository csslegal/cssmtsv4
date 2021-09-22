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
            ])

            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
            ->get();

        switch ($request->session()->get('userTypeId')) {
            case 2: //danisman
                return view('user.danisman.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
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
