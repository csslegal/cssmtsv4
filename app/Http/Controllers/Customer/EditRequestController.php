<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if (DB::table('customer_update')->insert([
            'user_id' => $request->session()->get('userId'),
            'customer_id' => $id,
            'onay' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ])) {
            return redirect('/musteri/' . $id . '/edit');
        } else {
            $request->session()->flash('mesajInfo', 'Talebiniz alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/edit');
        }
    }
}
