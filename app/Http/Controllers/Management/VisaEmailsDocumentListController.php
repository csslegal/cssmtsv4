<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaEmailsDocumentListController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('visa_emails_document_list')
            ->select(
                'language.name AS l_name',
                'visa_emails_document_list.id',
                'visa_emails_document_list.created_at',
                'visa_emails_document_list.updated_at',
                'visa_sub_types.name AS vst_name',
                'visa_types.name AS vt_name',
            )
            ->leftJoin(
                'visa_sub_types',
                'visa_sub_types.id',
                '=',
                'visa_emails_document_list.visa_sub_type_id'
            )
            ->leftJoin(
                'visa_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->leftJoin(
                'language',
                'language.id',
                '=',
                'visa_emails_document_list.language_id'
            )
            ->get();

        return view('yonetim.vize.emails-document.index')
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
        $language = DB::table('language')->get();

        $visaSubTypes = DB::table('visa_types')
            ->select(
                'visa_types.name AS vt_name',
                'visa_sub_types.name AS vst_name',
                'visa_sub_types.id AS id',
            )
            ->join(
                'visa_sub_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->get();

        return view('yonetim.vize.emails-document.create')
            ->with(
                [
                    'visaSubTypes' => $visaSubTypes,
                    'language' => $language,
                ]
            );
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
            'dil' => 'required|numeric',
            'vize-tipi' => 'required|numeric',
            'icerik' => 'required|min:3'
        ]);
        if (
            DB::table('visa_emails_document_list')
            ->where(
                'language_id',
                '=',
                $request->input('dil')
            )
            ->where(
                'visa_sub_type_id',
                '=',
                $request->input('vize-tipi')
            )->get()->count() == 0
        ) {
            if ($kayitId = DB::table('visa_emails_document_list')->insertGetId(
                [
                    'language_id' => $request->input('dil'),
                    'content' => $request->input('icerik'),
                    'visa_sub_type_id' => $request->input('vize-tipi'),
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ]
            )) {
                DB::table('visa_emails_document_list')
                    ->where('id', '=', $kayitId)
                    ->update([
                        'orderby' => $kayitId
                    ]);
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla kaydedildi');
                return redirect('yonetim/vize/evrak-emaili');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
                return redirect('yonetim/vize/evrak-emaili');
            }
        } else {
            $request->session()
                ->flash('mesajInfo', 'Vize tipi ve dil seçimine göre önceden kayıt yapıldı');
            return redirect('yonetim/vize/evrak-emaili');
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
        $language = DB::table('language')->get();

        $visaSubTypes = DB::table('visa_types')
            ->select(
                'visa_types.name AS vt_name',
                'visa_sub_types.name AS vst_name',
                'visa_sub_types.id AS id',
            )
            ->join(
                'visa_sub_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->get();

        $kayit = DB::table('visa_emails_document_list')
            ->where('id', '=', $id)
            ->first();

        return view('yonetim.vize.emails-document.edit')
            ->with(
                [
                    'kayit' => $kayit,
                    'visaSubTypes' => $visaSubTypes,
                    'language' => $language,
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
            'dil' => 'required|numeric',
            'vize-tipi' => 'required|numeric',
            'icerik' => 'required|min:3'
        ]);

        if (is_numeric($id)) {

            if ($request->input('vize-tipi') != $id) {

                if (
                    DB::table('visa_emails_document_list')
                    ->where('language_id', '=', $request->input('dil'))
                    ->where('visa_sub_type_id', '=', $request->input('vize-tipi'))
                    ->get()->count() == 0
                ) {

                    if (
                        DB::table('visa_emails_document_list')
                        ->where('id', '=', $id)
                        ->update(
                            [
                                'language_id' => $request->input('dil'),
                                'content' => $request->input('icerik'),
                                'visa_sub_type_id' => $request->input('vize-tipi'),
                                "updated_at" => date('Y-m-d H:i:s')
                            ]
                        )
                    ) {
                        $request->session()
                            ->flash('mesajSuccess', 'Başarıyla güncellendi');
                        return redirect('yonetim/vize/evrak-emaili');
                    } else {
                        $request->session()
                            ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                        return redirect('yonetim/vize/evrak-emaili');
                    }
                } else {
                    $request->session()
                        ->flash('mesajInfo', 'Dil ve Vize tipine ait kayıt bulundu');
                    return redirect('yonetim/vize/evrak-emaili');
                }
            } else {
                if (
                    DB::table('visa_emails_document_list')
                    ->where('id', '=', $id)
                    ->update(
                        [
                            'language_id' => $request->input('dil'),
                            'content' => $request->input('icerik'),
                            'visa_sub_type_id' => $request->input('vize-tipi'),
                            "updated_at" => date('Y-m-d H:i:s')
                        ]
                    )
                ) {
                    $request->session()
                        ->flash('mesajSuccess', 'Başarıyla güncellendi');
                    return redirect('yonetim/vize/evrak-emaili');
                } else {
                    $request->session()
                        ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                    return redirect('yonetim/vize/evrak-emaili');
                }
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/evrak-emaili');
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
                DB::table('visa_emails_document_list')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/vize/evrak-emaili');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/vize/evrak-emaili');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/evrak-emaili');
        }
    }
}
