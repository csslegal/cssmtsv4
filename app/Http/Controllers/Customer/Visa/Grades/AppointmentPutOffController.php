<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentPutOffController extends Controller
{
    public function index($id, $visa_file_id)
    {
        $customerAppointment = DB::table('visa_appointments')
            ->where('visa_file_id', '=', $visa_file_id)->first();


        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $times = DB::table('times')->get();

        return view('customer.visa.grades.appointment-putoff')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'customerAppointment' => $customerAppointment,
                    'times' => $times,
                ]
            );
    }

    public function store(Request $request, $id, $visa_file_id)
    {
        if ($request->input('odemeli') == 'odemeli') {
            /**randevu için yeniden odeme alma */

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            if ($nextGrades != null) {

                DB::table('visa_files')
                    ->where("id", "=", $visa_file_id)
                    ->update([
                        'visa_file_grades_id' => $nextGrades
                    ]);


                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }


                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Randevu erteleme, randevu alınması için ödeme alınması gerekli',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {

                $request->session()
                    ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        } else {
            /****randevu yenileme işlemine git*/
            $validatorStringArray = array(

                'tarih' => 'required',
                'saat' => 'required',
            );

            $request->validate($validatorStringArray);

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update([
                    'visa_file_grades_id' => env('VISA_DACTYLOGRAM_GRADES_ID')
                ]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Randevu erteleme, randevu bilgileri ödemesiz güncellendi',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $request->session()
                ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
