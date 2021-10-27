<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id)
    {
        $baseCustomerDetails = DB::table('customers')->select([
            'customers.id AS id',
            'visa_files.id AS visa_file_id',
        ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

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

        return view('customer.visa.grades.invoices-save')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'invoices' => $invoices,
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

            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
        } else {
            $request->session()
                ->flash('mesajDanger', 'İşlem sıralasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
        }
    }

    public function destroy($id, $visa_file_id, $invoice_id, Request $request)
    {
        if (is_numeric($invoice_id)) {
            if (DB::table('visa_invoices')->where('id', '=', $invoice_id)->delete()) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');

                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
        }
    }

    public function tamamla($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Fatura kaydı tamamlandı',
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
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/fatura-kayit');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
