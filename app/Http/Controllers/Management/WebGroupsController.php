<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebGroupsController extends Controller
{

    public function index()
    {
        $results = DB::table('web_groups')->get();
        return view('management.web.groups.index')->with(['results' => $results]);
    }

    public function create()
    {
        return view('management.web.groups.create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $request->validate(['name' => 'required|max:100min:3']);
        if ($kayitId = DB::table('web_groups')->insertGetId([
            'name' => $name,
            " " =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            DB::table('web_groups')
                ->where('id', '=', $kayitId)
                ->update(['orderby' => $kayitId]);
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/web/groups');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/web/groups');
        }
    }

    public function edit($id)
    {
        $result = DB::table('web_groups')->where('id', '=', $id)->first();
        return view('management.web.groups.edit')->with(['result' => $result]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|max:100|min:3']);
        if (is_numeric($id)) {
            if (
                DB::table('web_groups')->where('id', '=', $id)->update([
                    'name' => $request->input('name'),
                    "updated_at" => date('Y-m-d H:i:s')
                ])
            ) {
                $request->session()->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/web/groups');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/web/groups');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/groups');
        }
    }

    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (DB::table('web_groups')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/groups');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/web/groups');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/groups');
        }
    }
}
