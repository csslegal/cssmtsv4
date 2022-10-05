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

        return view("customer.add");
    }

    public function store(Request $request)
    {
        $passport = null;
        $passport_date = null;
        $application_office = null;
        $tc_number = null;
        $address = null;
        $note = null;

        $validatorStringArray = array(
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric|min:7',
            'email' => 'required|min:3|email',
        );
        if ($request->get('not') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('content' => 'string|min:3'));
            $note = $request->get('not');
        }
        if ($request->get('address') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('address' => 'string|min:3'));
            $address = $request->get('address');
        }
        if ($request->get('tc_number') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('tc_number' => 'min:10|unique:customers|numeric'));
            $tc_number = $request->get('tc_number');
        }
        $request->validate($validatorStringArray);

        $customerVarmiCount = DB::table('customers')
            ->where('name', '=', $request->get('name'))
            ->where('phone', '=', $request->get('phone'))
            ->get()->count();
        if ($customerVarmiCount == 0) {

            $name = mb_convert_case(mb_strtolower($request->get('name')), MB_CASE_TITLE, "UTF-8");
            $phone = $request->get('phone');
            $email = $request->get('email');

            $user_id = $request->session()->get('userId');

            $customer_id = DB::table('customers')->insertGetId([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'user_id' => $user_id,
                'tc_number' => $tc_number,
                'address' => $address,
                'passport' => $passport,
                'passport_date' => $passport_date,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($note != "") {
                $customerNoteId = DB::table('customer_notes')->insertGetId([
                    'user_id' => $user_id,
                    'customer_id' => $customer_id,
                    'content' => $note,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                DB::table('customer_notes')->where(['id' => $customerNoteId])->update(['orderby' => $customerNoteId]);
            }
            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/sorgula');
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
                'customers.phone AS phone',
                'customers.email AS email',
                'customers.tc_number AS tc_number',
                'customers.address AS address',
                'customers.passport AS passport',
                'customers.passport_date AS passport_date',
                'customers.information_confirm  AS information_confirm',
            ]);

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

            $visaFileGradesDescLog = DB::table('visa_file_logs')->select([
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

        return view('customer.edit')->with(['baseCustomerDetails' => $baseCustomerDetails,]);
    }

    public function update(Request $request, $id)
    {
        $validatorStringArray = array();
        $updateArray = array();
        $logsArray = array();

        $currentCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        $validatorStringArray = array_merge($validatorStringArray, array('name' => 'required|string|min:3',));
        $validatorStringArray = array_merge($validatorStringArray, array('phone' => 'required|numeric|min:7'));
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
        if ($currentCustomerDetails->phone != $request->get('phone')) {
            $updateArray = array_merge($updateArray, array('phone' => $request->get('phone')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri telefon güncelleme',
                'before' => $currentCustomerDetails->phone,
                'after' => $request->get('phone'),
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
        if ($currentCustomerDetails->address != $request->get('address')) {
            $updateArray = array_merge($updateArray, array('address' => $request->get('address')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri adresi güncelleme',
                'before' => $currentCustomerDetails->address,
                'after' => $request->get('address'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->tc_number != $request->get('tc_number')) {
            $updateArray = array_merge($updateArray, array('tc_number' => $request->get('tc_number')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri kimlik no güncelleme',
                'before' => $currentCustomerDetails->tc_number,
                'after' => $request->get('tc_number'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }


        if ($currentCustomerDetails->passport != $request->get('passport')) {
            $updateArray = array_merge($updateArray, array('passport' => $request->get('passport')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri pasaportu güncelleme',
                'before' => $currentCustomerDetails->passport,
                'after' => $request->get('passport'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        if ($currentCustomerDetails->passport_date != $request->get('passport_date')) {
            $updateArray = array_merge($updateArray, array('passport_date' => $request->get('passport_date')));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri pasaport tarihi güncelleme',
                'before' => $currentCustomerDetails->passport_date,
                'after' => $request->get('passport_date'),
                'customer_id' => $id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }

        $informationConfirm = $request->get('email-onay') != null ? 1 : 0;

        if ($currentCustomerDetails->information_confirm != $informationConfirm) {
            $updateArray = array_merge($updateArray, array('information_confirm' => $informationConfirm));
            array_push($logsArray, array(
                'operation_name' => 'Müşteri email onayı güncelleme',
                'before' => $currentCustomerDetails->information_confirm == 1 ? 'Onaylı' : 'Onaysız',
                'after' => $informationConfirm == 1 ? 'Onaylı' : 'Onaysız',
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
