<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class PaymentsController extends Controller
{
    public function index($id, $visa_file_id, Request $request)
    {
        //dd($request->input());
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        $visaFileReceivedGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_PAYMENT_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileReceivedGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileReceivedGradesUserType
        );

        $visaFileReceivedConfirmGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_PAYMENT_CONFIRM_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileReceivedConfirmGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileReceivedConfirmGradesUserType
        );

        $visaFileReceivedGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_PAYMENT_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileReceivedGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileReceivedGradesUserType
        );

        $visaFileMadeGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileMadeGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileMadeGradesUserType
        );

        $visaFileRefundGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_FILE_REFUND_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileRefundGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileRefundGradesUserType
        );

        $visaFileRefundConfirmGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileRefundConfirmGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileRefundConfirmGradesUserType
        );

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

        $madePaymentTypes = DB::table('visa_made_payment_types')->get();


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
            ->where('visa_file_id', '=', $visa_file_id)
            ->get();

        $refundPaymentTypes = DB::table('visa_refund_payment_types')->get();

        return view('customer.visa.payments')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'receivedPayments' => $receivedPayments,
            'receivedPaymentTypes' => $receivedPaymentTypes,
            'refundPayments' => $refundPayments,
            'refundPaymentTypes' => $refundPaymentTypes,
            'madePayments' => $madePayments,
            'madePaymentTypes' => $madePaymentTypes,
            'visaFileReceivedGradesPermitted' => $visaFileReceivedGradesPermitted,
            'visaFileReceivedConfirmGradesPermitted' => $visaFileReceivedConfirmGradesPermitted,
            'visaFileRefundGradesPermitted' => $visaFileRefundGradesPermitted,
            'visaFileRefundConfirmGradesPermitted' => $visaFileRefundConfirmGradesPermitted,
            'visaFileMadeGradesPermitted' => $visaFileMadeGradesPermitted,

        ]);
    }

    public function store(Request $request, $id, $visa_file_id)
    {
        if ($request->has('received')) {
            $tl_kurus = "00";
            $toplam_kurus = "00";
            $dolar_kurus = "00";
            $euro_kurus = "00";
            $pound_kurus = "00";

            $validatorStringArray = array(
                'alinan_tipleri' => 'required',
                'alinan_toplam' => 'numeric|required',
                'alinan_sekli' => 'required',
                'alinan_tarihi' => 'required',
            );

            $insertDataArray = array(
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            if ($request->input('alinan_tl_kurus') != "") {
                $tl_kurus = $request->input('alinan_tl_kurus');
            }
            if ($request->input('alinan_dolar_kurus') != "") {
                $dolar_kurus = $request->input('alinan_dolar_kurus');
            }
            if ($request->input('alinan_toplam_kurus') != "") {
                $toplam_kurus = $request->input('alinan_toplam_kurus');
            }
            if ($request->input('alinan_euro_kurus') != "") {
                $euro_kurus = $request->input('alinan_euro_kurus');
            }
            if ($request->input('alinan_pound_kurus') != "") {
                $pound_kurus = $request->input('alinan_pound_kurus');
            }

            if ($request->input('alinan_tl') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('alinan_tl' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'received_tl' => $request->input('alinan_tl') . "." . $tl_kurus
                ));
            }

            if ($request->input('alinan_euro') != "") {
                $validatorStringArray = array_merge($validatorStringArray,   array('alinan_euro' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'received_euro' => $request->input('alinan_euro') . "." . $euro_kurus
                ));
            }

            if ($request->input('alinan_pound') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('alinan_pound' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'received_pound' => $request->input('alinan_pound ') . "." . $pound_kurus
                ));
            }
            if ($request->input('alinan_dolar') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('alinan_dolar' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'received_dolar' => $request->input('alinan_dolar') . "." . $dolar_kurus
                ));
            }

            $request->validate($validatorStringArray);
            $paymentTypes = implode(', ', $request->input('alinan_tipleri'));

            $insertDataArray = array_merge($insertDataArray, array(
                'name' => $paymentTypes,
                'payment_method' => $request->input('alinan_sekli'),
                'payment_date' => $request->input('alinan_tarihi'),
                'payment_total' => $request->input('alinan_toplam') . "." . $toplam_kurus,
            ));

            if (DB::table('visa_received_payments')->insert($insertDataArray)) {
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            }
        }
        if ($request->has('made')) {

            $tl_kurus = "00";
            $toplam_kurus = "00";
            $dolar_kurus = "00";
            $euro_kurus = "00";
            $pound_kurus = "00";

            $validatorStringArray = array(
                'yapilan_tipleri' => 'required',
                'yapilan_toplam' => 'numeric|required',
                'yapilan_sekli' => 'required',
                'yapilan_tarihi' => 'required',
            );

            $insertDataArray = array(
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            if ($request->input('yapilan_tl_kurus') != "") {
                $tl_kurus = $request->input('yapilan_tl_kurus');
            }
            if ($request->input('yapilan_dolar_kurus') != "") {
                $dolar_kurus = $request->input('yapilan_dolar_kurus');
            }
            if ($request->input('yapilan_toplam_kurus') != "") {
                $toplam_kurus = $request->input('yapilan_toplam_kurus');
            }
            if ($request->input('yapilan_euro_kurus') != "") {
                $euro_kurus = $request->input('yapilan_euro_kurus');
            }
            if ($request->input('yapilan_pound_kurus') != "") {
                $pound_kurus = $request->input('yapilan_pound_kurus');
            }

            if ($request->input('yapilan_tl') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('yapilan_tl' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'made_tl' => $request->input('yapilan_tl') . "." . $tl_kurus
                ));
            }

            if ($request->input('yapilan_euro') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('yapilan_euro' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'made_euro' => $request->input('yapilan_euro') . "." . $euro_kurus
                ));
            }

            if ($request->input('yapilan_pound') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('yapilan_pound' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'made_pound' => $request->input('yapilan_pound ') . "." . $pound_kurus
                ));
            }
            if ($request->input('yapilan_dolar') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('yapilan_dolar' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'made_dolar' => $request->input('yapilan_dolar') . "." . $dolar_kurus
                ));
            }

            $request->validate($validatorStringArray);
            $paymentTypes = implode(', ', $request->input('yapilan_tipleri'));

            $insertDataArray = array_merge($insertDataArray, array(
                'name' => $paymentTypes,
                'payment_method' => $request->input('yapilan_sekli'),
                'payment_date' => $request->input('yapilan_tarihi'),
                'payment_total' => $request->input('yapilan_toplam') . "." . $toplam_kurus,
            ));

            if (DB::table('visa_made_payments')->insert($insertDataArray)) {
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            }
        }

        if ($request->has('refund')) {
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

            if ($request->input('iade_tl_kurus') != "") {
                $tl_kurus = $request->input('iade_tl_kurus');
            }
            if ($request->input('iade_dolar_kurus') != "") {
                $dolar_kurus = $request->input('iade_dolar_kurus');
            }
            if ($request->input('iade_toplam_kurus') != "") {
                $toplam_kurus = $request->input('iade_toplam_kurus');
            }
            if ($request->input('iade_euro_kurus') != "") {
                $euro_kurus = $request->input('iade_euro_kurus');
            }
            if ($request->input('iade_pound_kurus') != "") {
                $pound_kurus = $request->input('iade_pound_kurus');
            }

            if ($request->input('iade_tl') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('iade_tl' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'refund_tl' => $request->input('iade_tl') . "." . $tl_kurus
                ));
            }

            if ($request->input('iade_euro') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('iade_euro' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'refund_euro' => $request->input('iade_euro') . "." . $euro_kurus
                ));
            }

            if ($request->input('iade_pound') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('iade_pound' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'refund_pound' => $request->input('iade_pound ') . "." . $pound_kurus
                ));
            }
            if ($request->input('iade_dolar') != "") {
                $validatorStringArray = array_merge($validatorStringArray, array('iade_dolar' => 'string|min:1'));
                $insertDataArray = array_merge($insertDataArray, array(
                    'refund_dolar' => $request->input('iade_dolar') . "." . $dolar_kurus
                ));
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
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            } else {
                $request->session()->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
            }
        }
    }

    public function update(Request $request, $id, $visa_file_id, $payment_id)
    {
        if (is_numeric($payment_id)) {
            if ($request->has('received')) {

                if (DB::table('visa_received_payments')->where('id', '=', $payment_id)->update(['confirm' => 1, 'updated_at' => date('Y-m-d H:i:s')])) {
                    $request->session()->flash('mesajSuccess', 'İşlem başarıyla yapıldı');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                } else {
                    $request->session()
                        ->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                }
            }
            if ($request->has('refund')) {

                if (DB::table('visa_refund_payments')->where('id', '=', $payment_id)->update(['confirm' => 1, 'updated_at' => date('Y-m-d H:i:s')])) {
                    $request->session()->flash('mesajSuccess', 'İşlem başarıyla yapıldı');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                } else {
                    $request->session()->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                }
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
        }
    }

    public function destroy($id, $visa_file_id, $payment_id, Request $request)
    {
        if (is_numeric($payment_id)) {
            if ($request->has('received')) {

                if (DB::table('visa_received_payments')->where('id', '=', $payment_id)->delete()) {
                    $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                } else {
                    $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                }
            }
            if ($request->has('made')) {

                if (DB::table('visa_made_payments')->where('id', '=', $payment_id)->delete()) {
                    $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                } else {
                    $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                }
            }
            if ($request->has('refund')) {

                if (DB::table('visa_refund_payments')->where('id', '=', $payment_id)->delete()) {
                    $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                } else {
                    $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
                }
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/odeme');
        }
    }
}
