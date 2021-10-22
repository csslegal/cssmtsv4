<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MadePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select(
                [
                    'customers.id AS id',
                    'visa_files.id AS visa_file_id',
                ]
            )
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

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

            ->where('visa_file_id', '=', $visa_file_id)
            ->get();

        $madePaymentTypes = DB::table('visa_made_payment_types')->get();

        return view('customer.visa.grades.made-payments')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'madePayments' => $madePayments,
                    'madePaymentTypes' => $madePaymentTypes,
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, $visa_file_id, Request $request)
    {
        $tl_kurus = "00";
        $toplam_kurus = "00";
        $dolar_kurus = "00";
        $euro_kurus = "00";
        $pound_kurus = "00";

        $validatorStringArray = array(
            'odeme_tipleri' => 'required',
            'yapilan_toplam' => 'numeric|required',
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

        if ($request->input('yapilan_tl') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('yapilan_tl' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'made_tl' => $request->input('yapilan_tl') . "." . $tl_kurus
                )
            );
        }

        if ($request->input('yapilan_euro') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('yapilan_euro' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'made_euro' => $request->input('yapilan_euro') . "." . $euro_kurus
                )
            );
        }

        if ($request->input('yapilan_pound') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('yapilan_pound' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'made_pound' => $request->input('yapilan_pound ') . "." . $pound_kurus
                )
            );
        }
        if ($request->input('yapilan_dolar') != "") {
            $validatorStringArray = array_merge(
                $validatorStringArray,
                array('yapilan_dolar' => 'string|min:1')
            );
            $insertDataArray = array_merge(
                $insertDataArray,
                array(
                    'made_dolar' => $request->input('yapilan_dolar') . "." . $dolar_kurus
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
                'payment_total' => $request->input('yapilan_toplam') . "." . $toplam_kurus,
            )
        );

        if (DB::table('visa_made_payments')->insert($insertDataArray)) {
            $request->session()
                ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yapilan-odeme');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yapilan-odeme');
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
    public function destroy($id, $visa_file_id, $made_payment_id, Request $request)
    {
        if (is_numeric($made_payment_id)) {
            if (
                DB::table('visa_made_payments')
                ->where('id', '=', $made_payment_id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');

                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yapilan-odeme');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yapilan-odeme');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yapilan-odeme');
        }
    }
    public function tamamla($id, $visa_file_id, Request $request)
    {

        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)
            ->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Yapılan ödemeler tamamlandı',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update(['visa_file_grades_id' => $nextGrades])
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize/');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/alinan-odeme');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
