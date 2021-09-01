<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function post_duyuru_icerik_cek(Request $request)
    {

        if (is_numeric($request->input('id'))) {
            return DB::table('notice')->select('icerik')->where('id', '=', $request->input('id'))->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }
    public function get_aktif_duyuru_sayisi()
    {
        return DB::table('notice')->where('aktif', '=', 1)->get()->count();
    }
}
