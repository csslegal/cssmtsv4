<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CloseConfirmController extends Controller
{
    public function index($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        return view('customer.visa.grades.close-confirm')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        if ($request->has('onayla')) {

            $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
            $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Dosya kapama isteği onaylandı',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            if ($nextGrades != null) {

                if (DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades])) {

                    if ($request->session()->has($visa_file_id . '_grades_id')) {
                        $request->session()->forget($visa_file_id . '_grades_id');
                    }
                    $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                    return redirect('/musteri/' . $id . '/vize');
                } else {
                    $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize');
                }
            } else {
                $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        }

        if ($request->has('reddet')) {

            $visaFiles = DB::table('visa_files')->where('id', '=', $visa_file_id)->first();
            $visaFileGradesName = new VisaFileGradesName($visaFiles->visa_file_grades_id);

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Dosya kapama isteği iptal edildi.',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $visaFiles->temp_grades_id])) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
    }
}
