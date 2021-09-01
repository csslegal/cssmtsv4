<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaController extends Controller
{
    public function get_index()
    {
        $countVisaTypes=DB::table('visa_types')->get()->count();
        $countVisaSubTypes=DB::table('visa_sub_types')->get()->count();
        $countVisaEmailInformationList=DB::table('visa_emails_information')->get()->count();
        $countVisaEmailDocumentList=DB::table('visa_emails_document_list')->get()->count();

        return view('yonetim.vize.index')->with(
            [
                'countVisaTypes' => $countVisaTypes,
                'countVisaSubTypes' => $countVisaSubTypes,
                'countVisaEmailInformationList' => $countVisaEmailInformationList,
                'countVisaEmailDocumentList' => $countVisaEmailDocumentList,
            ]
        );
    }
    public function get_danisman(Request $request)
    {
        return view('yonetim.vize.danisman');
    }
    public function get_uzman(Request $request)
    {
        return view('yonetim.vize.uzman');
    }
    public function get_tercuman(Request $request)
    {
        return view('yonetim.vize.tercuman');
    }
    public function get_muhasebe(Request $request)
    {
        return view('yonetim.vize.muhasebe');
    }
    public function get_ofis_sorumlusu(Request $request)
    {
        return view('yonetim.vize.ofis-sorumlusu');
    }
    public function get_koordinator(Request $request)
    {
        $musteriTemelBilgileriGuncellemeIstekleri = DB::table('customer_update AS mg')
            ->select(
                'u.id AS u_id',
                'u.name AS u_name',
                'm.name AS m_name',
                'mg.created_at AS tarih',
                'mg.onay AS onay',
                'mg.id AS mg_id',
                'm.id AS m_id'
            )
            ->join('customers AS m', 'm.id', '=', 'mg.customer_id')
            ->join('users AS u', 'u.id', '=', 'mg.user_id')
            ->get();

        return view('yonetim.vize.koordinator')->with(
            [
                'musteriTemelBilgileriGuncellemeIstekleri' => $musteriTemelBilgileriGuncellemeIstekleri
            ]
        );
    }
}
