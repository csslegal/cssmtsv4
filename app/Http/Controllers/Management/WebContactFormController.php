<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebContactFormController extends Controller
{
    public function index($panel_id)
    {
        $webPanel = DB::table('web_panels')->where('id', '=', $panel_id)->first();
        $contactForm  = DB::table('web_contact_form')->get();
        return view('management.web.api-panels.contact-form.index')->with([
            'contactForm' => $contactForm,
            'webPanel' => $webPanel
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($panel_id, $contactform_id, Request $request)
    {
        if (is_numeric($contactform_id)) {
            if (DB::table('web_contact_form')->where('id', '=', $contactform_id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/contact-form');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/contact-form');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/api-panels');
        }
    }
}
