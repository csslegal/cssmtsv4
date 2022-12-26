<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol as MyClassInputKontrol;
use App\MyClass\MesaiKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $inputKontrol = new MyClassInputKontrol();

        //her ihtimale harşı güvenlik kontrolu
        $email =  $inputKontrol->kontrol($request->input('email'));
        $password = base64_encode($inputKontrol->kontrol($request->input('password')));

        /**** Yetkisiz ofis dışında giris kontrolu */
        $unlimitedControlCount = DB::table('users')
            ->where('email', '=', $email)
            ->where('unlimited', '=', 1)
            ->where('active', '=', 1)
            ->get()->count();

        if (DB::table('application_offices')->where('ip', '=', $request->ip())->get()->count() > 0 || $unlimitedControlCount > 0) {
            $request->validate([
                'email' => 'required|max:255|email',
                'password' => 'required|min:8',
            ]);

            $emailControl = DB::table('users')->where('email', '=', $email)->where('active', '=', 1)->get();
            if ($emailControl->count() > 0) {

                $passwordControl = $emailControl->where('password', '=', $password);
                if ($passwordControl->count() > 0) {

                    $users = $passwordControl->first();
                    $mesaiControl = new MesaiKontrol($users->id);
                    if ($mesaiControl->kontrol() == 1 || $unlimitedControlCount > 0) {

                        $request->session()->put('session', time() + (config('app.oturumSuresi') * 60));
                        $request->session()->put('userId', $users->id);
                        $request->session()->put('userTypeId', $users->user_type_id);
                        $request->session()->put('userName', $users->name);
                        $request->session()->put('theme', 'light');
                        if ($users->user_type_id == 1) {
                            return redirect('/yonetim');
                        } else {
                            return redirect('/kullanici');
                        }
                    } elseif ($mesaiControl->kontrol() == 2) {
                        $request->session()->flash('mesaj', 'Mesai saatleriniz sistemde kaydı değil');
                        return view('general.login');
                    } else {
                        $request->session()->flash('mesaj', 'Mesai saatleri içinde veya özel yetkiye sahip giriş yapabilir');
                        return view('general.login');
                    }
                } else {
                    $request->session()->flash('mesaj', 'Şifre hatalı girildi');
                    return view('general.login');
                }
            } else {
                $request->session()->flash('mesaj', 'Böyle bir kullanıcı bulunamadı');
                return view('general.login');
            }
        } else {
            $request->session()
                ->flash('mesaj', 'Sadece ofis içerisinden veya özel yetkiye sahip kullanıcılar giriş yapabilir');
            return view('general.login');
        }
    }

    public function get_index(Request $request)
    {
        if ($request->session()->has('session')) {

            if ($request->session()->get('userTypeId') == 1) {
                return redirect('/yonetim');
            } elseif (DB::table('users_type')->where('id', '=', $request->session()->get('userTypeId'))->get()->count() > 0) {
                return redirect('/kullanici');
            } else {
                return view('general.401');
            }
        } else {
            return redirect('giris');
        }
    }

    public function get_cikis(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function index(Request $request)
    {
        if ($request->session()->has('session')) {
            return redirect('/');
        } else {
            return view('general.login');
        }
    }
    public function post_theme(Request $request)
    {
        if ($request->session()->has('theme')) {

            if ($request->input('theme') == 'light') {
                $request->session()->put('theme', 'light');
                return 1;
            } else if ($request->input('theme') == 'system') {
                $request->session()->put('theme', 'system');
                return 1;
            } else {
                $request->session()->put('theme', 'dark');
                return 1;
            }
        }
    }
}
