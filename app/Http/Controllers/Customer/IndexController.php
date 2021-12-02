<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->flash('mesajDanger', 'Hatalı istek yapıldı');
        return redirect('/musteri/sorgula');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $randevuOfisleri = DB::table('appointment_offices')->get();
        $basvuruOfisleri = DB::table('application_offices')->get();

        return view("customer.add")->with([
            'basvuruOfisleri' => $basvuruOfisleri,
            'randevuOfisleri' => $randevuOfisleri
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pasaport = null;
        $pasaport_tarihi = null;
        $basvuru_ofis = null;
        $randevu_ofis = null;
        $tcno = null;
        $adres = null;
        $pasaport = null;
        $not = null;

        $validatorStringArray = array(
            'name' => 'required|string|min:3',
            'telefon' => 'required|numeric|min:7',
            'email' => 'required|min:3|email',
        );
        if ($request->get('not') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('content' => 'string|min:3'));
            $not = $request->get('not');
        }
        if ($request->get('adres') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('adres' => 'string|min:3'));
            $adres = $request->get('adres');
        }
        if ($request->get('tcno') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('tcno' => 'min:10|unique:customers|numeric'));
            $tcno = $request->get('tcno');
        }
        $request->validate($validatorStringArray);

        $customerVarmiCount = DB::table('customers')->where('name', '=', $request->get('name'))->where('telefon', '=', $request->get('telefon'))->get()->count();
        if ($customerVarmiCount == 0) {
            $name = mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8");
            $telefon = $request->get('telefon');
            $email = $request->get('email');
            $user_id = $request->session()->get('userId');

            if ($request->get('basvuru_ofis') != "") {
                $basvuru_ofis = $request->get('basvuru_ofis');
            }
            if ($request->get('randevu_ofis') != "") {
                $randevu_ofis = $request->get('randevu_ofis');
            }
            if ($customer_id = DB::table('customers')
                ->insertGetId([
                    'name' => $name,
                    'telefon' => $telefon,
                    'email' => $email,
                    'user_id' => $user_id,
                    'application_office_id' => $basvuru_ofis,
                    'appointment_office_id' => $randevu_ofis,
                    'tcno' => $tcno,
                    'adres' => $adres,
                    'pasaport' => $pasaport,
                    'pasaport_tarihi' => $pasaport_tarihi,
                    'created_at' => date('Y-m-d H:i:s')
                ])
            ) {
                if ($not != "") {
                    $customerNotId = DB::table('customer_notes')
                        ->insertGetId([
                            'user_id' => $user_id,
                            'customer_id' => $customer_id,
                            'content' => $not,
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                    DB::table('customer_notes')->where(['id' => $customerNotId])->update(['orderby' => $customerNotId]);
                }
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/sorgula');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
                return redirect('/musteri/sorgula');
            }
        } else {
            $request->session()->flash('mesajInfo', 'Müşteri kaydı mevcut. Arama yapınız');
            return redirect('/musteri/sorgula');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'customers.telefon AS telefon',
                'customers.email AS email',
                'customers.tcno AS tcno',
                'customers.adres AS adres',
                'customers.pasaport AS pasaport',
                'customers.pasaport_tarihi AS pasaport_tarihi',
                'application_offices.name AS application_name',
                'appointment_offices.name AS appointment_name',
            ])
            ->leftJoin('application_offices', 'application_offices.id', '=', 'customers.application_office_id')
            ->leftJoin('appointment_offices', 'appointment_offices.id', '=', 'customers.appointment_office_id');

        if (is_numeric($id) && $baseCustomerDetails->where('customers.id', '=', $id)->get()->count() > 0) {

            $baseCustomerDetails = $baseCustomerDetails->where('customers.id', '=', $id)->first();

            $userAccesses = DB::table('users_access')->select('access.id',)
                ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
                ->where('user_id', '=', $request->session()->get('userId'))
                ->pluck('access.id')->toArray();

            $customerNotlari = DB::table('customer_notes as mn')
                ->select([
                    "u.name AS u_name",
                    "mn.id AS mn_id",
                    "mn.created_at AS mn_created_at",
                    "mn.content AS mn_content"
                ])
                ->join("users AS u", "u.id", "=", "mn.user_id")
                ->where("mn.customer_id", "=", $id)->get();

            $customerEmailLogs = DB::table('email_logs')
                ->select([
                    'email_logs.id AS id',
                    'users.name AS u_name',
                    'access.name AS a_name',
                    'email_logs.subject AS subject',
                    'email_logs.created_at AS created_at',
                ])
                ->leftJoin('users', 'users.id', '=', 'email_logs.user_id')
                ->leftJoin('access', 'access.id', '=', 'email_logs.access_id')
                ->where('email_logs.customer_id', '=', $id)->get();

            $visaFileGradesDescLog = DB::table('visa_file_logs')
                ->select([
                    'visa_file_logs.id AS id',
                    'visa_file_logs.subject AS subject',
                    'visa_file_logs.created_at AS created_at',
                    'users.name AS user_name',
                    'visa_files.id AS visa_file_id',
                ])
                ->join('visa_files', 'visa_files.id', '=', 'visa_file_logs.visa_file_id')
                ->leftJoin('users', 'users.id', '=', 'visa_file_logs.user_id')
                ->where('visa_files.customer_id', '=', $id)
                ->where('visa_files.active', '=', 1)
                ->orderByDesc('id')
                ->first();

            return view('customer.index')->with([
                'baseCustomerDetails' => $baseCustomerDetails,
                'customerNotlari' => $customerNotlari,
                'userAccesses' => $userAccesses,
                'customerEmailLogs' => $customerEmailLogs,
                'visaFileGradesDescLog' => $visaFileGradesDescLog,
            ]);
        } else {
            $request->session()->flash('mesajDanger', 'Müşteri ID bilgisi alınamadı');
            return redirect('/musteri');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        $randevuOfisleri = DB::table('appointment_offices')->get();
        $basvuruOfisleri = DB::table('application_offices')->get();


        $guncellemeIstegi = DB::table('customer_update')->where('customer_id', '=', $id)
            ->where('user_id', '=', $request->session()->get('userId'))->first();

        if ($guncellemeIstegi != null) {
            if ($guncellemeIstegi->onay == 1) {
                $request->session()->flash('mesajSuccess', 'Güncelleme isteği onayı verildi');
            } else {
                $request->session()->flash('mesajInfo', 'Güncelleme isteği onay bekliyor');
            }
        }

        return view('customer.edit')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'basvuruOfisleri' => $basvuruOfisleri,
            'randevuOfisleri' => $randevuOfisleri,
            'guncellemeIstegiSayisi' => $guncellemeIstegi != null ? 1 : 0,
            'guncellemeIstegi' => $guncellemeIstegi == null ? null : $guncellemeIstegi
        ]);
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
        $validatorStringArray = array();
        $updateArray = array();

        /**NAME */
        $validatorStringArray = array_merge($validatorStringArray, array('name' => 'required|string|min:3',));
        $updateArray = array_merge($updateArray, array('name' => mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8")));
        /***END NAME */

        /**TELEFON */
        $validatorStringArray = array_merge($validatorStringArray, array('telefon' => 'required|numeric|min:7'));
        $updateArray = array_merge($updateArray, array('telefon' => $request->get('telefon')));
        /** END TELEFON */

        /**EMAİL */
        $validatorStringArray = array_merge($validatorStringArray, array('email' => 'required|min:3|email'));
        $updateArray = array_merge($updateArray, array('email' => $request->get('email')));
        /*** END EMAİL */

        /**ADRES */
        $updateArray = array_merge($updateArray, array('adres' => $request->get('adres')));
        /** END ADRES */

        $updateArray = array_merge($updateArray, array('tcno' => $request->get('tcno')));

        /**randevu basvuru */
        $updateArray = array_merge($updateArray, array('application_office_id' => $request->get('basvuru_ofis')));
        $updateArray = array_merge($updateArray, array('appointment_office_id' => $request->get('randevu_ofis')));

        /**pasaport */
        $updateArray = array_merge($updateArray, array('pasaport' => $request->get('pasaport')));
        /**END pasaport */

        /**pasaport tarihi*/
        $updateArray = array_merge($updateArray, array('pasaport_tarihi' => $request->get('pasaport_tarihi')));
        /**end pasaport tarihi */

        $request->validate($validatorStringArray);

        if (DB::table('customers')->where('id', '=', $id)->update($updateArray)) {

            DB::table('customer_update')->where('customer_id', '=', $id)->where('user_id', '=', $request->session()->get('userId'))->delete();

            $request->session()->flash('mesajSuccess', 'Güncelleme başarıyla yapıldı');
            return redirect('/musteri/' . $id);
        } else {
            $request->session()->flash('mesajDanger', 'Güncelleme sırasında sorun oluştu');
            return redirect('/musteri/' . $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        if (is_numeric($id)) {
            if (DB::table('customers')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla silindi');
                return redirect('/musteri');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt silinirken sorun oluştu');
                return redirect('/musteri/' . $id);
            }
        } else {
            $request->session()->flash('mesajInfo', 'ID bilgisi alınırken sorun oluştu');
            return redirect('/musteri/' . $id);
        }
    }
}
