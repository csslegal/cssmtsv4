<?php

namespace App\Http\Controllers\Genel;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol as MyClassInputKontrol;
use App\MyClass\MesaiKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GirisController extends Controller
{
    public function store(Request $request)
    {
        //IP kontrolu yapılıyor
        if (
            DB::table('application_offices')
            ->where('ip', '=', $request->ip())
            ->get()
            ->count() > 0
        ) {

            //her ihtimale harşı güvenlik kontrolu
            $inputKontrol = new MyClassInputKontrol();

            $email =  $inputKontrol->kontrol($request->input('email'));
            $password = base64_encode($inputKontrol->kontrol($request->input('password')));


            $request->validate([
                'email' => 'required|max:255|email',
                'password' => 'required|min:8',
            ]);

            $emailVarmi = DB::table('users')
                ->where('email', '=', $email)
                ->where('aktif', '=', 1)
                ->get();

            if ($emailVarmi->count() > 0) {

                $sifreDogruMu = $emailVarmi->where('password', '=', $password);

                if ($sifreDogruMu->count() > 0) {

                    $users = $sifreDogruMu->first();

                    //Mesai saati kontrolu
                    $mesaiKontrolu = new MesaiKontrol($users->id);

                    if ($mesaiKontrolu->kontrol() == 1) {

                        $request->session()->put('session', time() + (config('app.oturumSuresi') * 60));
                        $request->session()->put('userId', $users->id);
                        $request->session()->put('userTypeId', $users->user_type_id);
                        $request->session()->put('userName', $users->name);

                        if ($users->user_type_id == 1) {
                            //Admin sayfası
                            return redirect('/yonetim');
                        } else {
                            //Admin harici herkes
                            return redirect('/kullanici');
                        }
                    } elseif (($mesaiKontrolu->kontrol()) == 2) {
                        $request->session()
                            ->flash('mesaj', 'Mesai saatleriniz sistemde kaydı bulunamadı');
                        return view('genel.giris');
                    } else {
                        $request->session()
                            ->flash('mesaj', 'Mesai saatleri dışında giriş yapılamaz');
                        return view('genel.giris');
                    }
                } else {
                    $request->session()
                        ->flash('mesaj', 'Şifre hatalı girildi');
                    return view('genel.giris');
                }
            } else {
                $request->session()
                    ->flash('mesaj', 'Böyle bir kullanıcı bulunamadı');
                return view('genel.giris');
            }
        } else {
            $request->session()
                ->flash('mesaj', 'Sadece ofis içerisinden veya özel yetkiye sahip kullanıcılar giriş yapabilir');
            return view('genel.giris');
        }
    }

    public function get_index(Request $request)
    {
        if ($request->session()->has('session')) {

            if ($request->session()->get('userTypeId') == 1) {
                //Admin sayfası
                return redirect('/yonetim');
            } elseif (
                DB::table('users_type')
                ->where('id', '=', $request->session()->get('userTypeId'))
                ->get()
                ->count() > 0
            ) {
                //Admin harici herkes
                return redirect('/kullanici');
            } else {
                //farklı type ise hatalı istek
                return view('genel.401');
            }
        } else {
            //Oturum yok ise giriş sayfasına yönlendirilecek
            return redirect('giris');
        }
    }

    public function get_cikis(Request $request)
    {
        $request->session()->forget('session');
        $request->session()->forget('userId');
        $request->session()->forget('userTypeId');
        $request->session()->forget('userName');
        return redirect(config('app.url'));
    }

    public function index(Request $request)
    {
        if ($request->session()->has('session')) {
            return redirect(config('app.url'));
        } else {
            return view('genel.giris');
        }
    }
}
