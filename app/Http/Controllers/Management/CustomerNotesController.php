<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerNotesController extends Controller
{
    public function index()
    {
        $customerNotes = DB::table('customer_notes')->select([
            'customer_notes.id AS id',
            'customer_notes.created_at AS created_at',
            'customers.id AS customer_id',
            'customers.name AS name',
            'users.name AS user_name',
        ])
            ->leftJoin('customers', 'customers.id', '=', 'customer_notes.customer_id')
            ->leftJoin('users', 'users.id', '=', 'customer_notes.user_id')
            ->get();

        return view('management.customer-notes.index')->with([
            'customerNotes' => $customerNotes,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'not' => 'required',
            'customer_id' => 'required',
        ]);

        $customer_id = $request->input('customer_id');

        $customerNotId = DB::table('customer_notes')
            ->insertGetId([
                'user_id' => $request->session()->get('userId'),
                'customer_id' => $customer_id,
                'content' => $request->get('not'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        DB::table('customer_notes')->where(['id' => $customerNotId])->update(['orderby' => $customerNotId]);

        $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/yonetim/customer-notes');
    }
    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (
                DB::table('customer_notes')->where('id', '=', $id)->delete()
            ) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/customer-notes');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/customer-notes');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/customer-notes');
        }
    }
}
