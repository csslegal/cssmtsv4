<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{


    public function index(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request->validate([
            'note' => 'required',
        ]);

        $customerNoteId = DB::table('customer_notes')
            ->insertGetId([
                'user_id' => $request->session()->get('userId'),
                'customer_id' => $id,
                'content' => $request->get('note'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        DB::table('customer_notes')->where(['id' => $customerNoteId])->update(['orderby' => $customerNoteId]);

        $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/musteri/' . $id . '#notes');
    }

    /**
     *
     */
    public function destroy($id, $note_id, Request $request)
    {

        if (DB::table('customer_notes')->where('id', '=', $note_id)->delete()) {
            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla silindi');
            return redirect('/musteri/' . $id . '#notes');
        } else {
            $request->session()->flash('mesajDanger', 'Silme işlemi tamamlanamadı');
            return redirect('/musteri/' . $id . '#notes');
        }
    }
}
