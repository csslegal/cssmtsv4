<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        if (is_numeric($id)) {
            $request->validate([
                'alt_vize' => 'required|numeric',
                'dil' => 'required|numeric',
            ]);

            $visaSubInformationEmailContent = DB::table('visa_emails_information')
                ->select(
                    "visa_types.name AS vt_name",
                    "visa_sub_types.name AS vta_name",
                    "visa_emails_information.content AS content"
                )
                ->leftJoin(
                    "visa_sub_types",
                    "visa_sub_types.id",
                    "=",
                    "visa_emails_information.visa_sub_type_id"
                )
                ->leftJoin(
                    "visa_types",
                    "visa_types.id",
                    "=",
                    "visa_sub_types.visa_type_id"
                )
                ->where([
                    "visa_sub_types.id" => $request->input("alt_vize"),
                    "visa_emails_information.language_id" => $request->input("dil")
                ])->first();

            if ($visaSubInformationEmailContent != null) {

                /**$customer = DB::table('customer')->where('id', '=', $id)->first();
               Mail::send(
                    'email.email-information',
                    [
                        'customer' => $customer,
                        'visaSubInformationEmailContent' => $visaSubInformationEmailContent
                    ],
                    function ($m) use ($customer) {
                        $m->to($customer->email, $customer->name)
                            ->subject('Vize İşlemleri Bilgi E-maili | ' . date("His"))
                            ->bcc('mehmetaliturkan@engin.group', $name = null);
                    }
                );*/

                DB::table('email_logs')->insert(
                    [
                        'customer_id' => $id,
                        'access_id' => 1, //vize işlem emaili
                        'content' => $visaSubInformationEmailContent->content,
                        'subject' => 'CSSLEGAL | Vize İşlemleri Bilgi E-maili | ' . date("His"),
                        'user_id' => $request->session()->get('userId'),
                        'created_at' => date('Y-m-d H:i:s'),
                    ]
                );
                $request->session()
                    ->flash('mesajSuccess', 'Bilgi e-maili gönderildi');
                return redirect('/musteri/' . $id . '/vize#email');
            } else {
                $request->session()
                    ->flash('mesajInfo', 'Bu vize tipi için bilgi emaili girilmedi');
                return redirect('/musteri/' . $id . '/vize#email');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı müşteri bilgisi');
            return redirect('/musteri/' . $id . '/vize#email');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
