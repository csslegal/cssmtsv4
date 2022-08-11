<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationResultController extends Controller
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

        return view('customer.visa.grades.application-result')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $visaApplicationResultCount = DB::table('visa_application_result')->where('visa_file_id', '=', $visa_file_id)->get()->count();

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($request->input('sonuc') == 1) {
            /***vize alırsa */
            $validatorStringArray = array(
                'vize_baslangic_tarihi' => 'required',
                'vize_bitis_tarihi' => 'required',
                'vize_teslim_alinma_tarihi' => 'required',
            );
            $request->validate($validatorStringArray);

            if ($nextGrades != null) {

                $dataArray = array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'visa_result' => $request->input('sonuc'),
                    'visa_start_date' => $request->input('vize_baslangic_tarihi'),
                    'visa_end_date' => $request->input('vize_bitis_tarihi'),
                    'visa_delivery_accepted_date' => $request->input('vize_teslim_alinma_tarihi'),
                    'visa_refusal_reason' => '',
                    'visa_refusal_date' => '',
                    'visa_refusal_delivery_accepted_date' => '',
                    'visa_file_close_date' => date('Y-m-d'),
                );
                if ($visaApplicationResultCount > 0) {
                    $dataArray = array_merge($dataArray, array('updated_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->where("visa_file_id", "=", $visa_file_id)->update($dataArray);
                } else {
                    $dataArray = array_merge($dataArray, array('created_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->insert($dataArray);
                }
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades]);

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Vize Sonucu OLUMLU olarak kaydedildi',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        } elseif ($request->input('sonuc') == 2) {
            /*** iade olursa */
            $validatorStringArray = array();
            $request->validate($validatorStringArray);

            if ($nextGrades != null) {

                $dataArray = array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'visa_result' => $request->input('sonuc'),
                    'visa_start_date' => '',
                    'visa_end_date' => '',
                    'visa_delivery_accepted_date' => '',
                    'visa_refusal_reason' => '',
                    'visa_refusal_date' => '',
                    'visa_refusal_delivery_accepted_date' => '',
                    'visa_file_close_date' => date('Y-m-d'),
                );
                if ($visaApplicationResultCount > 0) {
                    $dataArray = array_merge($dataArray, array('updated_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->where("visa_file_id", "=", $visa_file_id)->update($dataArray);
                } else {
                    $dataArray = array_merge($dataArray, array('created_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->insert($dataArray);
                }
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades]);

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Vize Sonucu İADE olarak kaydedildi',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        } else {
            /***Ret alırsa */
            $validatorStringArray = array(
                'red_sebebi' => 'required',
                'red_tarihi' => 'required',
                'red_teslim_alinma_tarihi' => 'required',
            );
            $request->validate($validatorStringArray);

            if ($nextGrades != null) {

                $dataArray = array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'visa_result' => $request->input('sonuc'),
                    'visa_start_date' => '',
                    'visa_end_date' => '',
                    'visa_delivery_accepted_date' => '',
                    'visa_refusal_reason' => $request->input('red_sebebi'),
                    'visa_refusal_date' => $request->input('red_tarihi'),
                    'visa_refusal_delivery_accepted_date' => $request->input('red_teslim_alinma_tarihi'),
                    'visa_file_close_date' => date('Y-m-d'),
                );
                if ($visaApplicationResultCount > 0) {
                    $dataArray = array_merge($dataArray, array('updated_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->where("visa_file_id", "=", $visa_file_id)->update($dataArray);
                } else {
                    $dataArray = array_merge($dataArray, array('created_at' => date('Y-m-d H:i:s')));
                    DB::table('visa_application_result')->insert($dataArray,);
                }
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades]);

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Vize Sonucu OLUSUZ olarak kaydedildi',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
    }
}
