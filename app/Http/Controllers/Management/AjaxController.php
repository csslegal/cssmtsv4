<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function post_duyuru_cek(Request $request)
    {

        if (is_numeric($request->input('id'))) {
            return DB::table('notice')
                ->select('icerik')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }
    public function post_users_type_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('users_type')
                ->select(['name'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }
    public function post_bilgi_emaili_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('visa_emails_information')
                ->select(['content'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }
    public function post_evrak_emaili_cek(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('visa_emails_document_list')
                ->select(['content'])
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }
}
