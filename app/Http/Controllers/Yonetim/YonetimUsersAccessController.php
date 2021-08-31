<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YonetimUsersAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('access')
            ->get();

        return view('yonetim.users-access.index')
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
        return view('yonetim.users-access.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        $request->validate([
            'name' => 'required|max:100min:3'
        ]);

        if ($kayitId = DB::table('access')->insertGetId(
            [
                'name' => $name,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        )) {
            DB::table('access')
                ->where('id', '=', $kayitId)
                ->update([
                    'orderby' => $kayitId
                ]);
            $request->session()
                ->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/users-access');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/users-access');
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
        $kayit = DB::table('access')
            ->where('id', '=', $id)
            ->first();
        return view('yonetim.users-access.edit')
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
        $request->validate([
            'name' => 'required|max:100|min:3'
        ]);

        if (is_numeric($id)) {
            if (
                DB::table('access')
                ->where('id', '=', $id)
                ->update(
                    [
                        'name' => $request->input('name'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                )
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/users-access');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/users-access');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/users-access');
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
                DB::table('access')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/users-access');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/users-access');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/users-access');
        }
    }
}
