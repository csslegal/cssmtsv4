<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DuyuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kayitlar = DB::table('notice AS d')
            ->select(
                'd.id AS d_id',
                'u.name AS u_name',
                'd.aktif AS d_aktif',
                'd.created_at AS d_tarih',
                'd.updated_at AS d_u_tarih'
            )
            ->leftJoin('users AS u', 'u.id', '=', 'd.user_id')
            ->get();

        return view('yonetim.duyuru.index')
            ->with(
                ['kayitlar' => $kayitlar]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('yonetim.duyuru.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'icerik' => 'required|max:1000|min:3'
        ]);

        if (DB::table('notice')->insert(
            [
                'user_id' => $request->session()->get('userId'),
                'icerik' => $request->input('icerik'),
                'aktif' => 1,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        )) {
            $request->session()
                ->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/duyuru');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kayit = DB::table('notice')
            ->select('icerik', 'id', 'aktif')
            ->where('id', '=', $id)
            ->first();
        return view('yonetim.duyuru.edit')
            ->with(
                [
                    'kayit' => $kayit
                ]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($request->has('aktif')) {
            $aktif = 1;
        } else {
            $aktif = 0;
        }

        $request->validate([
            'icerik' => 'required|max:1000|min:3'
        ]);

        if (is_numeric($id)) {
            if (
                DB::table('notice')
                ->where('id', '=', $id)
                ->update(
                    [
                        'aktif' => $aktif,
                        'icerik' => $request->input('icerik'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                )
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/duyuru');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/duyuru');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        if (is_numeric($id)) {
            if (
                DB::table('notice')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/duyuru');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/duyuru');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/duyuru');
        }
    }
}
