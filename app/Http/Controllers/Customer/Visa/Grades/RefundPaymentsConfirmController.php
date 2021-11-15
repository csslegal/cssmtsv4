<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefundPaymentsConfirmController extends Controller
{
    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

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

        return view('customer.visa.grades.refund-payments-confirm')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'refundPayments' => $refundPayments,
        ]);
    }

    public function update($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'İadeler onaylandı',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('visa_refund_payments')->where('visa_file_id', '=', $visa_file_id)->update(['confirm' => 1, 'updated_at' => date('Y-m-d H:i:s')]);

        if (DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => env('VISA_FILE_DELIVERY_GRADES_ID')])) {

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', 'İşlem başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/');
        } else {

            $request->session()->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/alinan-odeme-onay');
        }
    }

    public function destroy($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'İade bilgileri iptal edildi',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('visa_refund_payments')->where('visa_file_id', '=', $visa_file_id)->delete();

        if (DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => env('VISA_FILE_REFUND_GRADES_ID')])) {

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', 'İşlem başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/');
        } else {

            $request->session()->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
