<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentCancelController extends Controller
{
    public function index($id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        return view('customer.visa.grades.appointment-cancel')
            ->with(['baseCustomerDetails' => $baseCustomerDetails,]);
    }

    public function create()
    {
    }

    public function store(Request $request, $id, $visa_file_id)
    {
        if ($request->has('kapat')) {
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
                'content' => 'Randevu iptali, dosya kapatıldı.',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update([
                    'visa_file_grades_id' => env('VISA_FILE_DELIVERY_GRADES_ID')
                ])
            ) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
        if ($request->has('uzman')) {

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
                'content' => 'Randevu iptali, randevu tarihi erteleniyor.',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update([
                    'visa_file_grades_id' => env('VISA_APPOINTMENT_PUTOFF_GRADES_ID')
                ])
            ) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
        if ($request->has('onay')) {

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
                'content' => 'Randevu iptali, dosya onaylandı.',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')->where("id", "=", $visa_file_id)
                ->update([
                    'visa_file_grades_id' => env('VISA_DACTYLOGRAM_GRADES_ID')
                ])
            ) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
    }
}
