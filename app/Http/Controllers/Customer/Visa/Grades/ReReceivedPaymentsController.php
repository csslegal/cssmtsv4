<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReReceivedPaymentsController extends Controller
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
            ->where('visa_file_id', '=', $visa_file_id)
            ->get();

        $receivedPaymentTypes = DB::table('visa_received_payment_types')->get();

        return view('customer.visa.grades.re-received-payments')
            ->with([
                'baseCustomerDetails' => $baseCustomerDetails,
                'receivedPayments' => $receivedPayments,
                'receivedPaymentTypes' => $receivedPaymentTypes,
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
            'odeme_tipleri' => 'required',
            'alinan_toplam' => 'numeric|required',
            'odeme_sekli' => 'required',
            'odeme_tarihi' => 'required',
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

        if ($request->input('alinan_tl') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('alinan_tl' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'received_tl' => $request->input('alinan_tl') . "." . $tl_kurus
                )
            );
        }

        if ($request->input('alinan_euro') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('alinan_euro' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'received_euro' => $request->input('alinan_euro') . "." . $euro_kurus
                )
            );
        }

        if ($request->input('alinan_pound') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('alinan_pound' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'received_pound' => $request->input('alinan_pound ') . "." . $pound_kurus
                )
            );
        }
        if ($request->input('alinan_dolar') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('alinan_dolar' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'received_dolar' => $request->input('alinan_dolar') . "." . $dolar_kurus
                )
            );
        }

        $request->validate($validatorStringArray);

        $paymentTypes = implode(', ', $request->input('odeme_tipleri'));

        $insertDataArray = array_merge(
            $insertDataArray,
            array(
                'name' => $paymentTypes,
                'payment_method' => $request->input('odeme_sekli'),
                'payment_date' => $request->input('odeme_tarihi'),
                'payment_total' => $request->input('alinan_toplam') . "." . $toplam_kurus,
            )
        );

        if (DB::table('visa_received_payments')->insert($insertDataArray)) {
            $request->session()
                ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
        }
    }

    public function destroy($id, $visa_file_id, $received_payment_id, Request $request)
    {
        if (is_numeric($received_payment_id)) {
            if (
                DB::table('visa_received_payments')
                ->where('id', '=', $received_payment_id)->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');

                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
        }
    }

    public function tamamla($id, $visa_file_id, Request $request)
    {

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Yeniden alınan ödeme kayıtları tamamlandı',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')->where("id", "=", $visa_file_id)
                ->update(['visa_file_grades_id' => $nextGrades])
            ) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize/');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme');
            }
        } else {

            $request->session()
                ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
