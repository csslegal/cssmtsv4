<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomersController extends Controller
{

    public function index()
    {
        return view('management.customers.index');
    }

    public function create()
    {
        return view('management.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required']);

        $path = $request->file('file')->store('public/excel');
        Excel::import(new CustomersImport, $path);

        $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
        return redirect('yonetim/customers');
    }

    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (
                DB::table('customers')->where('id', '=', $id)->delete()
            ) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/customers');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/customers');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/customers');
        }
    }
}
