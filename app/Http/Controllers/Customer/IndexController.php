<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        return redirect('/musteri/sorgula');
    }

    public function create()
    {
        $randevuOfisleri = DB::table('appointment_offices')->get();
        $basvuruOfisleri = DB::table('application_offices')->get();

        return view("customer.add")->with([
            'basvuruOfisleri' => $basvuruOfisleri,
            'randevuOfisleri' => $randevuOfisleri
        ]);
    }

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
                    $customerNoteId = DB::table('customer_notes')
                        ->insertGetId([
                            'user_id' => $user_id,
                            'customer_id' => $customer_id,
                            'content' => $not,
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                    DB::table('customer_notes')->where(['id' => $customerNoteId])->update(['orderby' => $customerNoteId]);
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

            $customerNotes = DB::table('customer_notes')
                ->select([
                    "users.name AS u_name",
                    "customer_notes.id",
                    "customer_notes.created_at",
                    "customer_notes.content"
                ])
                ->join("users", "users.id", "=", "customer_notes.user_id")
                ->where("customer_notes.customer_id", "=", $id)->get();

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
                'customerNotes' => $customerNotes,
                'userAccesses' => $userAccesses,
                'customerEmailLogs' => $customerEmailLogs,
                'visaFileGradesDescLog' => $visaFileGradesDescLog,
            ]);
        } else {
            $request->session()->flash('mesajDanger', 'Müşteri ID bilgisi alınamadı');
            return redirect('/musteri');
        }
    }

    public function edit($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();
        $randevuOfisleri = DB::table('appointment_offices')->get();
        $basvuruOfisleri = DB::table('application_offices')->get();

        return view('customer.edit')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'randevuOfisleri' => $randevuOfisleri,
            'basvuruOfisleri' => $basvuruOfisleri,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatorStringArray = array();
        $updateArray = array();
        $logsArray = array();

        $currentCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        $validatorStringArray = array_merge($validatorStringArray, array('name' => 'required|string|min:3',));
        $validatorStringArray = array_merge($validatorStringArray, array('telefon' => 'required|numeric|min:7'));
        $validatorStringArray = array_merge($validatorStringArray, array('email' => 'required|min:3|email'));

        if ($currentCustomerDetails->name != mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8")) {
            $updateArray = array_merge($updateArray, array('name' => mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8")));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri adı güncelleme',
                'before' => $currentCustomerDetails->name,
                'after' => mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8"),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->telefon != $request->get('telefon')) {
            $updateArray = array_merge($updateArray, array('telefon' => $request->get('telefon')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri telefon güncelleme',
                'before' => $currentCustomerDetails->telefon,
                'after' => $request->get('telefon'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->email != $request->get('email')) {
            $updateArray = array_merge($updateArray, array('email' => $request->get('email')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri e-maili güncelleme',
                'before' => $currentCustomerDetails->email,
                'after' => $request->get('email'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->adres != $request->get('adres')) {
            $updateArray = array_merge($updateArray, array('adres' => $request->get('adres')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri adresi güncelleme',
                'before' => $currentCustomerDetails->adres,
                'after' => $request->get('adres'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->tcno != $request->get('tcno')) {
            $updateArray = array_merge($updateArray, array('tcno' => $request->get('tcno')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri kimlik no güncelleme',
                'before' => $currentCustomerDetails->tcno,
                'after' => $request->get('tcno'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->application_office_id != $request->get('basvuru_ofis')) {
            $updateArray = array_merge($updateArray, array('application_office_id' => $request->get('basvuru_ofis')));

            $beforeApplicationOffice = DB::table('application_offices')->select('name')->where('id', '=', $currentCustomerDetails->application_office_id)->first();
            $afterApplicationOffice = DB::table('application_offices')->select('name')->where('id', '=', $request->get('basvuru_ofis'))->first();
            array_push($logsArray, array(
                'operation_name' => 'Müşteri basvuru ofisi güncelleme',
                'before' => isset($beforeApplicationOffice->name) ? $beforeApplicationOffice->name : null,
                'after' => isset($afterApplicationOffice->name) ? $afterApplicationOffice->name : null,
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->appointment_office_id != $request->get('randevu_ofis')) {
            $updateArray = array_merge($updateArray, array('appointment_office_id' => $request->get('randevu_ofis')));

            $beforeAppointmentOffice = DB::table('appointment_offices')->select('name')->where('id', '=', $currentCustomerDetails->appointment_office_id)->first();
            $afterAppointmentOffice = DB::table('appointment_offices')->select('name')->where('id', '=', $request->get('randevu_ofis'))->first();

            array_push($logsArray, array(
                'operation_name' => 'Müşteri randevu ofisi güncelleme',
                'before' => isset($beforeAppointmentOffice->name) ? $beforeAppointmentOffice->name : null,
                'after' => isset($afterAppointmentOffice->name) ? $afterAppointmentOffice->name : null,
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->pasaport != $request->get('pasaport')) {
            $updateArray = array_merge($updateArray, array('pasaport' => $request->get('pasaport')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri pasaportu güncelleme',
                'before' => $currentCustomerDetails->pasaport,
                'after' => $request->get('pasaport'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->pasaport_tarihi != $request->get('pasaport_tarihi')) {
            $updateArray = array_merge($updateArray, array('pasaport_tarihi' => $request->get('pasaport_tarihi')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri pasaport tarihi güncelleme',
                'before' => $currentCustomerDetails->pasaport_tarihi,
                'after' => $request->get('pasaport_tarihi'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }

        $bilgilendirmeEmailOnayi = $request->get('email-onay') != null ? 1 : 0;

        if ($currentCustomerDetails->bilgilendirme_onayi != $bilgilendirmeEmailOnayi) {
            $updateArray = array_merge($updateArray, array('bilgilendirme_onayi' => $bilgilendirmeEmailOnayi));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri email onayı güncelleme',
                'before' => $currentCustomerDetails->bilgilendirme_onayi == 1 ? 'Onaylı' : 'Onaysız',
                'after' => $bilgilendirmeEmailOnayi == 1 ? 'Onaylı' : 'Onaysız',
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        $request->validate($validatorStringArray);

        if ($updateArray != null) {

            if (DB::table('customers')->where('id', '=', $id)->update($updateArray)) {

                DB::table('customer_logs')->insert($logsArray);
                DB::table('customer_update')->where('customer_id', '=', $id)->where('user_id', '=', $request->session()->get('userId'))->delete();

                $request->session()->flash('mesajSuccess', 'Güncelleme başarıyla yapıldı');
                return redirect('/musteri/' . $id);
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sırasında sorun oluştu');
                return redirect('/musteri/' . $id);
            }
        } else {
            $request->session()->flash('mesajInfo', 'Değişiklik bulunamadı');
            return redirect('/musteri/' . $id);
        }
    }

    public function destroy($id, Request $request)
    {

        if (is_numeric($id)) {

            if (DB::table('customers')->where('id', '=', $id)->delete()) {

                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla silindi');
                return redirect('/musteri/sorgula');
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
