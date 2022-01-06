<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $userAccesses = DB::table('users_access')->select('access.id',)
            ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
            ->where('user_id', '=', $request->session()->get('userId'))
            ->pluck('access.id')->toArray();
        $webGroups = DB::table('web_groups')->get();
        $webPanels = DB::table('web_panel_auth')
            ->select([
                'web_panels.group_id', 'web_panels.name',
                'web_panels.url', 'web_panel_auth.access',
            ])
            ->join('web_panel_user', 'web_panel_auth.id', '=', 'web_panel_user.panel_auth_id')
            ->join('web_panels', 'web_panels.id', '=', 'web_panel_user.panel_id')
            ->where('web_panel_auth.user_id', '=', $request->session()->get('userId'))
            ->get();
        $webResults = DB::table('web_panel_auth')->where('user_id', '=', $request->session()->get('userId'))->get();
        if ($webResults->count() > 0) {
            //dd(date("Y-m-d", strtotime($webResults->start_time)) . " " . date("Y-m-d", time()));
            //suanki time başlangıctan buyuk sondan kucuk olamalı ki erişim izni olsun
            $webResultsFirst =  $webResults->first();
            $panelsTimeAccess = (strtotime($webResultsFirst->start_time) <= strtotime(date("Y-m-d", time()))) && (strtotime(date("Y-m-d", time())) <= strtotime($webResultsFirst->and_time));
        } else {
            $panelsTimeAccess = 2;
        }
        return view('web.index')->with([
            'webPanels' => $webPanels,
            'webGroups' => $webGroups,
            'panelsTimeAccess' => $panelsTimeAccess,
            'userAccesses' => $userAccesses,
        ]);
    }
}
