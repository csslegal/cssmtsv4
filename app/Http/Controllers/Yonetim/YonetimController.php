<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YonetimController extends Controller
{
    public function get_index(Request $request)
    {


        return view('yonetim.index')->with([
            'countUsers' => DB::table('users')->where('aktif', '=', '1')->get()->count(),
            'countUserType' => DB::table('users_type')->get()->count(),
            'countUserAccess' => DB::table('access')->get()->count(),
            'countApplicationOffice' => DB::table('application_offices')->get()->count(),
            'countAppointmentOffice' => DB::table('appointment_offices')->get()->count(),
            'countNotice' => DB::table('notice')->where('aktif', '=', '1')->get()->count(),
            'countLanguage' => DB::table('language')->get()->count(),

        ]);
    }

    public function get_TBGI_onay(Request $request, $mg_id)
    {

        if (is_numeric($mg_id)) {

            if (DB::table('customer_update')
                ->where('id', '=', $mg_id)
                ->update(['onay' => 1])

            ) {
                $request->session()->flash('mesajSuccess', 'Onay işlemi tamamlandı');
                return redirect('/yonetim/koordinator');
            }
        } else {
            $request->session()->flash('mesajDanger', 'Hatalı bilgi girdiniz');
            return redirect('/yonetim/koordinator');
        }
    }
    public function get_TBGI_gerial(Request $request, $mg_id)
    {

        if (is_numeric($mg_id)) {

            if (DB::table('customer_update')
                ->where('id', '=', $mg_id)
                ->update(['onay' => 0])

            ) {
                $request->session()->flash('mesajSuccess', 'Geri alma işlemi tamamlandı');
                return redirect('/yonetim/koordinator');
            }
        } else {
            $request->session()->flash('mesajDanger', 'Hatalı bilgi girdiniz');
            return redirect('/yonetim/koordinator');
        }
    }
}
