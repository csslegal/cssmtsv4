<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{

    public function index()
    {
        $kayitlar = DB::table('notice AS d')
            ->select([
                'd.id AS d_id',
                'u.name AS u_name',
                'd.active AS d_active',
                'd.created_at AS d_tarih',
                'd.updated_at AS d_u_tarih'
            ])
            ->leftJoin('users AS u', 'u.id', '=', 'd.user_id')->get();

        return view('management.notice.index')->with(['kayitlar' => $kayitlar]);
    }

    public function create()
    {
        return view('management.notice.create');
    }

    public function store(Request $request)
    {
        $request->validate(['icerik' => 'required|max:1000|min:3']);

        if (DB::table('notice')->insert([
            'user_id' => $request->session()->get('userId'),
            'icerik' => $request->input('icerik'),
            'active' => 1,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/duyuru');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }

    public function edit($id)
    {
        $kayit = DB::table('notice')->select('icerik', 'id', 'active')->where('id', '=', $id)->first();
        return view('management.notice.edit')->with(['kayit' => $kayit]);
    }

    public function update(Request $request, $id)
    {

        if ($request->has('active')) {
            $active = 1;
        } else {
            $active = 0;
        }

        $request->validate(['icerik' => 'required|max:1000|min:3']);

        if (is_numeric($id)) {
            if (DB::table('notice')->where('id', '=', $id)->update([
                'active' => $active,
                'icerik' => $request->input('icerik'),
                "updated_at" => date('Y-m-d H:i:s')
            ])) {
                $request->session()->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/duyuru');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/duyuru');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }

    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {

            if (DB::table('notice')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/duyuru');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/duyuru');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }
}
