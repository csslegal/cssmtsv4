<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebPanelsController extends Controller
{

    public function index()
    {
        $results  = DB::table('web_panels')
            ->select([
                'web_panels.id AS id',
                'web_panels.url AS url',
                'web_panels.name AS p_name',
                'web_panels.created_at AS created_at',
                'web_panels.updated_at AS updated_at',
                'web_panels.name AS p_name',
                'web_groups.name AS g_name',
            ])
            ->join('web_groups', 'web_groups.id', '=', 'web_panels.group_id')->get();

        return view('management.web.panels.index')->with(['results' => $results]);
    }

    public function create()
    {
        $results = DB::table('web_groups')->get();
        return view('management.web.panels.create')->with([
            'results' => $results,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'grup' => 'required|numeric',
            'site' => 'required|max:100min:3',
        ]);
        if ($kayitId = DB::table('web_panels')->insertGetId([
            'url' => $request->input('url'),
            'group_id' => $request->input('grup'),
            'name' => $request->input('site'),
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            DB::table('web_panels')->where('id', '=', $kayitId)->update(['orderby' => $kayitId]);
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/web/panels');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/web/panels');
        }
    }

    public function edit($id)
    {
        $resultGroups = DB::table('web_groups')->get();
        $result = DB::table('web_panels')->where('id', '=', $id)->first();

        return view('management.web.panels.edit')->with([
            'result' => $result,
            'resultGroups' => $resultGroups,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url',
            'grup' => 'required|numeric',
            'site' => 'required|max:100min:3',
        ]);
        if (is_numeric($id)) {
            if (
                DB::table('web_panels')->where('id', '=', $id)->update([
                    'url' => $request->input('url'),
                    'group_id' => $request->input('grup'),
                    'name' => $request->input('site'),
                    "updated_at" => date('Y-m-d H:i:s')
                ])
            ) {
                $request->session()->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/web/panels');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/web/panels');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/panels');
        }
    }

    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (DB::table('web_panels')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/panels');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/web/panels');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/panels');
        }
    }
}
