<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InformationEmailController extends Controller
{

    public function store($id, Request $request)
    {
        if (env('SENDING_MAIL')) {

            if (is_numeric($id)) {
                $request->validate(['alt_vize' => 'required|numeric', 'dil' => 'required|numeric',]);
                $visaSubInformation = DB::table('visa_emails_information')
                    ->select([
                        "visa_types.name AS vt_name",
                        "visa_sub_types.name AS vta_name",
                        "visa_emails_information.content AS content"
                    ])
                    ->leftJoin("visa_sub_types", "visa_sub_types.id", "=", "visa_emails_information.visa_sub_type_id")
                    ->leftJoin("visa_types", "visa_types.id", "=", "visa_sub_types.visa_type_id")
                    ->where([
                        "visa_sub_types.id" => $request->input("alt_vize"),
                        "visa_emails_information.language_id" => $request->input("dil")
                    ])->first();
                if ($visaSubInformation != null) {

                    $customer = DB::table('customers')->where('id', '=', $id)->first();
                    try {
                        Mail::send('email.information', ['customer' => $customer, 'visaSubInformation' => $visaSubInformation], function ($m) use ($customer) {
                            $m->to($customer->email, $customer->name)
                                ->subject('Bilgi E-maili ' . time() . ' | CSS Legal')
                                ->bcc('mehmetaliturkan@engin.group', $name = null);
                        });
                        DB::table('email_logs')->insert([
                            'customer_id' => $id,
                            'access_id' => 1, //vize işlem emaili
                            'content' => $visaSubInformation->content,
                            'subject' => 'Bilgi E-maili ' . time() . ' | CSS Legal',
                            'user_id' => $request->session()->get('userId'),
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        $request->session()->flash('mesajSuccess', 'Bilgi e-maili gönderildi');
                        return redirect('/musteri/' . $id . '/vize#email');
                    } catch (\Throwable $th) {
                        $request->session()->flash('mesajDanger', $th->getMessage());
                        return redirect('/musteri/' . $id . '/vize#email');
                    }
                } else {
                    $request->session()->flash('mesajInfo', 'Bu vize tipi için bilgi emaili girilmedi');
                    return redirect('/musteri/' . $id . '/vize#email');
                }
            } else {
                $request->session()->flash('mesajDanger', 'Hatalı müşteri bilgisi');
                return redirect('/musteri/' . $id . '/vize#email');
            }
        } else {
            $request->session()->flash('mesajInfo', 'Email gönderimi aktif değil.');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
