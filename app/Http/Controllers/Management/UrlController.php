<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\WebSiteUrls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webSiteUrls = DB::table('url')->get();

        return view('management.url.index')->with(
            [
                'kayitlar' => $webSiteUrls,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.url.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:url,name',
            ]
        );

        $name =  rtrim($request->input('name'), "/");

        if (DB::table('url')->where('name', '=', $name)->get()->count() == 0) {

            DB::table('url')->insert([
                'name' => $name,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]);

            $request->session()
                ->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('/url');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Sistemde kayıtlı');
            return redirect('/url');
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
        $webSite = DB::table('url')
            ->where('id', '=', $id)->first();

        $webSiteAnasayfaLinkleri = DB::table('url_anasayfa')
            ->where('url_id', '=', $id)->get();

        return view('management.url.anasayfa')->with(
            [
                'kayitlar' => $webSiteAnasayfaLinkleri,
                'webSite' => $webSite,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
                DB::table('url')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('url');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('url');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('url');
        }
    }

    public function get_home_links($id, Request $request)
    {
        $webSite = DB::table('url')
            ->where('id', '=', $id)->first();

        $WebSiteHome = new WebSiteUrls($webSite->name);
        $webSiteHomeUrls = $WebSiteHome->fetch();

        DB::table('url_anasayfa')
            ->where('url_id', '=', $id)->delete();

        foreach ($webSiteHomeUrls as $webSiteHomeUrl) {
            DB::table('url_anasayfa')->insert(
                [
                    'url_id' => $id,
                    'name' => $webSiteHomeUrl,
                ]
            );
        }
        $request->session()
            ->flash('mesajSuccess', 'Başarıyla alındı');
        return redirect('/url/' . $id);
    }

    public function get_subpage($id, $subId)
    {
        $webSite = DB::table('url')
            ->where('id', '=', $id)->first();

        $webSiteAnasayfa = DB::table('url_anasayfa')
            ->where('id', '=', $subId)->first();

        $webSiteUrls = DB::table('url')
            ->select([
                'url.name AS u_name',
                'url_anasayfa.name AS ana_name',
                'url_altsayfa.name AS alt_name',
                'url_altsayfa.id AS id',
            ])
            ->join('url_anasayfa', 'url.id', '=', 'url_anasayfa.url_id')
            ->join('url_altsayfa', 'url_anasayfa.id', '=', 'url_altsayfa.url_anasayfa_id')
            ->where('url_anasayfa.id', '=', $subId)
            ->get();

        return view('management.url.altsayfa')->with(
            [
                'kayitlar' => $webSiteUrls,
                'webSite' => $webSite,
                'webSiteAnasayfa' => $webSiteAnasayfa,
            ]
        );
    }
    public function get_subpage_links($id, $subId, Request $request)
    {
        $webSite = DB::table('url_anasayfa')
            ->where('id', '=', $subId)->first();

        $WebSiteHome = new WebSiteUrls($webSite->name);
        $webSiteHomeUrls = $WebSiteHome->fetch();

        //dd($webSiteHomeUrls);

        DB::table('url_altsayfa')
            ->where('url_anasayfa_id', '=', $subId)->delete();

        foreach ($webSiteHomeUrls as $webSiteHomeUrl) {
            DB::table('url_altsayfa')->insert(
                [
                    'url_anasayfa_id' => $subId,
                    'name' => $webSiteHomeUrl,
                ]
            );
        }
        $request->session()
            ->flash('mesajSuccess', 'Başarıyla alındı');
        return redirect('/url/' . $id . '/subpage/' . $subId);
    }

    public function get_ajax(Request $request)
    {
        $result = "";
        $id = $request->input('id');

        $webSite = DB::table('url')
            ->where('id', '=', $id)->first();

        DB::table('url_edits')
            ->where('url_id', '=', $id)->delete();

        $WebSiteHome = new WebSiteUrls($webSite->name);
        $webSiteHomeUrls = $WebSiteHome->fetch();

        for ($iHome = 0; $iHome < count($webSiteHomeUrls); $iHome++) {

            if (strpos($webSiteHomeUrls[$iHome], $webSite->name) !== false) {

                $WebSiteSubpage = new WebSiteUrls($webSiteHomeUrls[$iHome]);
                $webSiteSubpageUrls = $WebSiteSubpage->fetch();

                for ($iSubPage = 0; $iSubPage < count($webSiteSubpageUrls); $iSubPage++) {

                    if (strpos($webSiteSubpageUrls[$iSubPage], $webSite->name) !== false) {
                        //siteye ait link ise

                    } else {


                        if (array_key_exists('host', parse_url($webSiteSubpageUrls[$iSubPage]))) {

                            $urlSadelestirme = parse_url($webSiteSubpageUrls[$iSubPage])['host'];
                        } else {
                            $urlSadelestirme =  $webSiteSubpageUrls[$iSubPage];
                        }

                        if (
                            DB::table('url_edits')
                            ->where('url_id', '=', $id)
                            ->where('name', '=',  $urlSadelestirme)
                            ->count() == 0
                        ) {

                            DB::table('url_edits')->insert(
                                [
                                    'name' => $urlSadelestirme,
                                    'url_id' => $id,
                                    'count' => 1
                                ]
                            );
                        } else {

                            DB::table('url_edits')
                                ->where('url_id', '=', $id)
                                ->where('name', '=', $urlSadelestirme)
                                ->update(
                                    [
                                        'count' => DB::raw('count+1')
                                    ]
                                );
                        }
                    }
                }
            } else {
                //siteye ait link değilse
                if (array_key_exists('host', parse_url($webSiteHomeUrls[$iHome]))) {

                    $urlSadelestirme = parse_url($webSiteHomeUrls[$iHome])['host'];
                } else {
                    $urlSadelestirme =  $webSiteHomeUrls[$iHome];
                }
                if (
                    DB::table('url_edits')
                    ->where('url_id', '=', $id)
                    ->where('name', '=', $urlSadelestirme)
                    ->count() == 0
                ) {

                    DB::table('url_edits')->insert(
                        [
                            'name' =>  $urlSadelestirme,
                            'url_id' => $id,
                            'count' => 1
                        ]
                    );
                } else {

                    DB::table('url_edits')
                        ->where('url_id', '=', $id)
                        ->where('name', '=',  $urlSadelestirme)
                        ->update(
                            [
                                'count' => DB::raw('count+1')
                            ]
                        );
                }
            }
        }

        $result .= 'Link Çıkışı Sayıları:';
        $result .= '<ul>';

        $results = DB::table('url_edits')->where('url_id', '=', $id)->get();

        foreach ($results as $res) {
            $result .= '<li>' . $res->name . ' : <span class="fw-bold">' . $res->count . '</span></li>';
        }

        $result .= '</ul>';

        return $result;
    }
}
