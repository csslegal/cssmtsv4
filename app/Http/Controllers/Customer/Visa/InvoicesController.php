<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{

    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->select([
            'customers.id AS id',
            'visa_files.id AS visa_file_id',
        ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        if ($baseCustomerDetails == null) {
            $request->session()->flash('mesajDanger', 'Müşteri bilgisi bulunamadı');
            return redirect('/musteri/sorgula');
        }

        $visaFileInvoiceGradesUserType = DB::table('visa_file_grades_users_type')
            ->select(['user_type_id'])
            ->where('visa_file_grade_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
            ->pluck('user_type_id')->toArray();
        $visaFileInvoiceGradesPermitted = in_array(
            $request->session()->get('userTypeId'),
            $visaFileInvoiceGradesUserType
        );

        $invoices = DB::table('visa_invoices')->select([
            "visa_invoices.id AS id",
            "visa_invoices.payment AS payment",
            "visa_invoices.matrah AS matrah",
            "visa_invoices.date AS date",
            "visa_invoices.number AS number",
            "visa_invoices.created_at AS created_at",
            "users.name"
        ])
            ->Join("visa_files", "visa_files.id", "=", "visa_invoices.visa_file_id")
            ->leftJoin("users", "users.id", "=", "visa_invoices.user_id")
            ->where("visa_invoices.visa_file_id", "=", $visa_file_id)
            ->distinct()
            ->get();;

        return view('customer.visa.invoices')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'invoices' => $invoices,
            'visaFileInvoiceGradesPermitted' => $visaFileInvoiceGradesPermitted,
        ]);
    }

    public function store(Request $request, $id, $visa_file_id)
    {
        $matrah_kurus = "00";
        $odeme_kurus = "00";

        $validatorStringArray = array(
            'odeme' => 'required|numeric',
            'matrah' => 'required|numeric',
            'tarih' => 'required',
            'numara' => 'required',
        );

        $request->validate($validatorStringArray);

        if ($request->input('matrah') != null) {
            $matrah = $request->input('matrah') . "." . $matrah_kurus;
        }
        if ($request->input('odeme') != null) {
            $odeme = $request->input('odeme') . "." . $odeme_kurus;
        }

        if (DB::table('visa_invoices')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'visa_file_id' => $visa_file_id,
            'payment' => $odeme,
            'matrah' => $matrah,
            'date' => $request->input('tarih'),
            'number' => $request->input('numara'),
            'created_at' => date('Y-m-d H:i:s'),
        ])) {
            $request->session()
                ->flash('mesajSuccess', 'Başarıyla eklendi');

            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura');
        } else {
            $request->session()
                ->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura');
        }
    }

    public function destroy($id, $visa_file_id, $invoice_id, Request $request)
    {
        if (is_numeric($invoice_id)) {
            if (DB::table('visa_invoices')->where('id', '=', $invoice_id)->delete()) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');

                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura');
        }
    }
}
