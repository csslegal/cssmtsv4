<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request->validate(['not' => 'required']);

        $customerNotId = DB::table('customer_notes')
            ->insertGetId([
                'user_id' => $request->session()->get('userId'),
                'customer_id' => $id,
                'content' => $request->get('not'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        DB::table('customer_notes')->where(['id' => $customerNotId])->update(['orderby' => $customerNotId]);

        $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/musteri/' . $id);
    }
}
