<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaSubTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('visa_sub_types')
            ->select(
                'visa_sub_types.id',
                'visa_sub_types.created_at',
                'visa_sub_types.updated_at',
                'visa_sub_types.name AS vst_name',
                'visa_types.name AS vt_name',
            )
            ->leftJoin(
                'visa_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->get();

        return view('yonetim.vize.visa-sub-types.index')
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
        $visaTypes = DB::table('visa_types')->get();

        return view('yonetim.vize.visa-sub-types.create')->with([
            'visaTypes' => $visaTypes,
        ]);
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
            'vize-tipi' => 'required|numeric',
            'name' => 'required|max:100min:3'
        ]);

        if ($kayitId = DB::table('visa_sub_types')->insertGetId(
            [
                'name' => $request->input('name'),
                'visa_type_id' => $request->input('vize-tipi'),

                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        )) {
            DB::table('visa_sub_types')
                ->where('id', '=', $kayitId)
                ->update([
                    'orderby' => $kayitId
                ]);
            $request->session()
                ->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/vize/alt-vize-tipi');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/vize/alt-vize-tipi');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visaTypes = DB::table('visa_types')->get();
        $kayit = DB::table('visa_sub_types')
            ->where('id', '=', $id)
            ->first();
        return view('yonetim.vize.visa-sub-types.edit')
            ->with(
                [
                    'kayit' => $kayit,
                    'visaTypes' => $visaTypes,
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
            'vize-tipi' => 'required|numeric',
            'name' => 'required|max:100min:3'
        ]);

        if (is_numeric($id)) {
            if (
                DB::table('visa_sub_types')
                ->where('id', '=', $id)
                ->update(
                    [
                        'name' => $request->input('name'),
                        'visa_type_id' => $request->input('vize-tipi'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                )
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/vize/alt-vize-tipi');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/vize/alt-vize-tipi');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/alt-vize-tipi');
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
                DB::table('visa_sub_types')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/vize/alt-vize-tipi');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/vize/alt-vize-tipi');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/alt-vize-tipi');
        }
    }
}
