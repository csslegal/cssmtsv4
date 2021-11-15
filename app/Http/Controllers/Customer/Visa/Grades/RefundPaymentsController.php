<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefundPaymentsController extends Controller
{

    public function index($id, $visa_file_id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        $receivedPayments = DB::table('visa_received_payments')
            ->select([
                'visa_received_payments.id AS id',
                'visa_received_payments.name AS name',
                'visa_received_payments.received_tl AS received_tl',
                'visa_received_payments.received_euro AS received_euro',
                'visa_received_payments.received_dolar AS received_dolar',
                'visa_received_payments.received_pound AS received_pound',
                'visa_received_payments.payment_total AS payment_total',
                'visa_received_payments.payment_method AS payment_method',
                'visa_received_payments.payment_date AS payment_date',
                'visa_received_payments.confirm AS confirm',
                'visa_received_payments.created_at AS created_at',
                'users.name AS user_name',
            ])
            ->leftJoin('users', 'users.id', '=', 'visa_received_payments.user_id')
            ->where('visa_file_id', '=', $visa_file_id)->get();

        $madePayments = DB::table('visa_made_payments')
            ->select([
                'visa_made_payments.id AS id',
                'visa_made_payments.name AS name',
                'visa_made_payments.made_tl AS made_tl',
                'visa_made_payments.made_euro AS made_euro',
                'visa_made_payments.made_dolar AS made_dolar',
                'visa_made_payments.made_pound AS made_pound',
                'visa_made_payments.payment_total AS payment_total',
                'visa_made_payments.payment_method AS payment_method',
                'visa_made_payments.payment_date AS payment_date',
                'visa_made_payments.created_at AS created_at',
                'users.name AS user_name',
            ])
            ->leftJoin('users', 'users.id', '=', 'visa_made_payments.user_id')
            ->where('visa_file_id', '=', $visa_file_id)->get();

        $refundPayments = DB::table('visa_refund_payments')
            ->select([
                'visa_refund_payments.id AS id',
                'visa_refund_payments.name AS name',
                'visa_refund_payments.refund_tl AS refund_tl',
                'visa_refund_payments.refund_euro AS refund_euro',
                'visa_refund_payments.refund_dolar AS refund_dolar',
                'visa_refund_payments.refund_pound AS refund_pound',
                'visa_refund_payments.payment_total AS payment_total',
                'visa_refund_payments.payment_method AS payment_method',
                'visa_refund_payments.payment_date AS payment_date',
                'visa_refund_payments.confirm AS confirm',
                'visa_refund_payments.created_at AS created_at',
                'users.name AS user_name',
            ])
            ->leftJoin('users', 'users.id', '=', 'visa_refund_payments.user_id')
            ->where('visa_file_id', '=', $visa_file_id)->get();

        $refundPaymentTypes = DB::table('visa_refund_payment_types')->get();

        return view('customer.visa.grades.refund-payments')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'madePayments' => $madePayments,
            'receivedPayments' => $receivedPayments,
            'refundPayments' => $refundPayments,
            'refundPaymentTypes' => $refundPaymentTypes,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $tl_kurus = "00";
        $toplam_kurus = "00";
        $dolar_kurus = "00";
        $euro_kurus = "00";
        $pound_kurus = "00";

        $validatorStringArray = array(
            'iade_tipleri' => 'required',
            'iade_toplam' => 'numeric|required',
            'iade_sekli' => 'required',
            'iade_tarihi' => 'required',
        );

        $insertDataArray = array(
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'created_at' => date('Y-m-d H:i:s'),
        );

        if ($request->input('tl_kurus') != "") {
            $tl_kurus = $request->input('tl_kurus');
        }
        if ($request->input('dolar_kurus') != "") {
            $dolar_kurus = $request->input('dolar_kurus');
        }
        if ($request->input('toplam_kurus') != "") {
            $toplam_kurus = $request->input('toplam_kurus');
        }
        if ($request->input('euro_kurus') != "") {
            $euro_kurus = $request->input('euro_kurus');
        }
        if ($request->input('pound_kurus') != "") {
            $pound_kurus = $request->input('pound_kurus');
        }

        if ($request->input('iade_tl') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('iade_tl' => 'string|min:1'));
            $insertDataArray = array_merge($insertDataArray, array('refund_tl' => $request->input('iade_tl') . "." . $tl_kurus));
        }

        if ($request->input('iade_euro') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('iade_euro' => 'string|min:1'));
            $insertDataArray = array_merge($insertDataArray, array('refund_euro' => $request->input('iade_euro') . "." . $euro_kurus));
        }

        if ($request->input('iade_pound') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('iade_pound' => 'string|min:1'));
            $insertDataArray = array_merge($insertDataArray, array('refund_pound' => $request->input('iade_pound ') . "." . $pound_kurus));
        }
        if ($request->input('iade_dolar') != "") {
            $validatorStringArray = array_merge($validatorStringArray, array('iade_dolar' => 'string|min:1'));
            $insertDataArray = array_merge($insertDataArray, array('refund_dolar' => $request->input('iade_dolar') . "." . $dolar_kurus));
        }

        $request->validate($validatorStringArray);
        $paymentTypes = implode(', ', $request->input('iade_tipleri'));

        $insertDataArray = array_merge($insertDataArray, array(
            'name' => $paymentTypes,
            'payment_method' => $request->input('iade_sekli'),
            'payment_date' => $request->input('iade_tarihi'),
            'payment_total' => $request->input('iade_toplam') . "." . $toplam_kurus,
        ));

        if (DB::table('visa_refund_payments')->insert($insertDataArray)) {

            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
        }
    }

    public function destroy($id, $visa_file_id, $refund_payment_id, Request $request)
    {
        if (is_numeric($refund_payment_id)) {

            if (DB::table('visa_refund_payments')->where('id', '=', $refund_payment_id)->delete()) {

                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
            } else {

                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
            }
        } else {

            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
        }
    }

    public function tamamla($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if (DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades])) {

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/');
        } else {

            $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/iade-bilgileri');
        }
    }
}
