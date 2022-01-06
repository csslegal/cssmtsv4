<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebPanelAuthController extends Controller
{
    public function index()
    {
        $results = DB::table('web_panel_auth')->select([
            'web_panel_auth.id', 'web_panel_auth.start_time', 'web_panel_auth.and_time', 'web_panel_auth.access',
            'web_panel_auth.created_at', 'web_panel_auth.updated_at', 'users.name AS u_name',
        ])
            ->join('users', 'users.id', '=', 'web_panel_auth.user_id')->get();

        return view('management.web.panel-auth.index')->with([
            'results' => $results
        ]);
    }

    public function create()
    {
        $groups = DB::table('web_groups')->get();
        $panels = DB::table('web_panels')->get();
        $users = DB::table('users')->select(['users.id', 'users.name', 'users_type.name AS ut_name',])
            ->leftJoin('users_type', 'users_type.id', '=', 'users.user_type_id')->where('active', '=', 1)->get();

        return view('management.web.panel-auth.create')->with([
            'users' => $users, 'groups' => $groups, 'panels' => $panels,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kullanici' => 'required|numeric',
            'baslangic' => 'required',
            'bitis' => 'required',
            'erisim' => 'required',
            'panels' => 'required',
        ]);
        if (DB::table('web_panel_auth')->where('user_id', '=', $request->input('kullanici'))->count() > 0) {
            $request->session()->flash('mesajDanger', 'Bu kullanıcı daha önceden kaydedildi.');
            return redirect('yonetim/web/panel-auth');
        } else {
            if ($kayitId = DB::table('web_panel_auth')->insertGetId([
                'user_id' => $request->input('kullanici'), 'start_time' => $request->input('baslangic'), 'and_time' => $request->input('bitis'),
                'access' => $request->input('erisim'), "created_at" =>  date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s'),
            ])) {
                DB::table('web_panel_auth')->where('id', '=', $kayitId)->update(['orderby' => $kayitId]);
                foreach ($request->input('panels') as $panel) {
                    DB::table('web_panel_user')->insert([
                        'panel_id' => $panel, 'panel_auth_id' => $kayitId,
                        "created_at" =>  date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s'),
                    ]);
                }
                $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
                return redirect('yonetim/web/panel-auth');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
                return redirect('yonetim/web/panel-auth');
            }
        }
    }

    public function edit($id)
    {
        $panels = DB::table('web_panels')->get();
        $groups = DB::table('web_groups')->get();
        $result = DB::table('web_panel_auth')->where('id', '=', $id)->first();

        $users = DB::table('users')
            ->select([
                'users.id', 'users.name', 'users_type.name AS ut_name',
            ])
            ->leftJoin('users_type', 'users_type.id', '=', 'users.user_type_id')
            ->where('active', '=', 1)->get();

        $panelIDs = DB::table('web_panel_user')->select('panel_id')
            ->where('panel_auth_id', '=', $id)->get()->pluck('panel_id')->toArray();

        return view('management.web.panel-auth.edit')->with([
            'result' => $result,
            'users' => $users,
            'groups' => $groups,
            'panels' => $panels,
            'panelIDs' => $panelIDs,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kullanici' => 'required|numeric',
            'baslangic' => 'required',
            'bitis' => 'required',
            'erisim' => 'required',
        ]);
        if (is_numeric($id)) {
            if (
                DB::table('web_panel_auth')->where('id', '=', $id)->update([
                    'user_id' => $request->input('kullanici'), 'start_time' => $request->input('baslangic'),
                    'and_time' => $request->input('bitis'), 'access' => $request->input('erisim'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ])
            ) {
                DB::table('web_panel_user')->where('panel_auth_id', '=', $id)->delete();

                if ($request->input('panels') != null) {
                    foreach ($request->input('panels') as $panel) {
                        DB::table('web_panel_user')->insert([
                            'panel_id' => $panel, 'panel_auth_id' => $id,  "updated_at" => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
                $request->session()->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/web/panel-auth');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/web/panel-auth');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/panel-auth');
        }
    }

    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (DB::table('web_panel_auth')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/panel-auth');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/web/panel-auth');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/panel-auth');
        }
    }
}
