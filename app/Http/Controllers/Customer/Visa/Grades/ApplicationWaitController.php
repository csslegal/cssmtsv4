<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationWaitController extends Controller
{
    public function index($id, $visa_file_id)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();
        $visaFile = DB::table('visa_files')->where('id', '=', $visa_file_id)->first();

        $times = DB::table('times')->get();
        $appointmentOffices = DB::table('appointment_offices')->get();
        $users = DB::table('users')->orderBy('orderby')->get();


        return view('customer.visa.grades.appication-wait')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'appointmentOffices' => $appointmentOffices,
            'visaFile' => $visaFile,
            'times' => $times,
            'users' => $users,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        if ($request->session()->get('userTypeId') == 1) {
            $validatorStringArray = array(
                'gwf' => 'required',
                'uzman' => 'required',
                'ofis' => 'required',
                'hesap_adi' => 'required',
                'sifre' => 'required',
                'tarih' => 'required',
                'saat' => 'required',
            );
        } else {
            $validatorStringArray = array(
                'gwf' => 'required',
                'ofis' => 'required',
                'hesap_adi' => 'required',
                'sifre' => 'required',
                'tarih' => 'required',
                'saat' => 'required',
            );
        }

        $request->validate($validatorStringArray);

        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {
            $customerAppointmentCount = DB::table('visa_appointments')->where('visa_file_id', '=', $visa_file_id)->get()->count();
            $appointmentOffice = DB::table('appointment_offices')->where('id', '=', $request->input('ofis'))->first();

            if ($request->session()->get('userTypeId') == 1) {
                $user = DB::table('users')->where('id', '=', $request->input('uzman'))->first();
            } else {
                $user = DB::table('users')->where('id', '=', $request->session()->get('userId'))->first();
            }
            if ($customerAppointmentCount == 0) {
                DB::table('visa_appointments')->insert(array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'gwf' => $request->input('gwf'),
                    'name' => $request->input('hesap_adi'),
                    'password' => $request->input('sifre'),
                    'date' => $request->input('tarih'),
                    'time' => $request->input('saat'),
                    'created_at' => date('Y-m-d H:i:s'),
                ));
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Başvuru bekleyen dosyalar aşamasında;</p>
                                    Randevu Bilgileri
                                    <ul>
                                        <li>GWF numarası: ' . $request->input('gwf') . ',</li>
                                        <li>Randevu ofisi: ' . $appointmentOffice->name . ',</li>
                                        <li>Randevu tarihi: ' . $request->input('tarih') . ',</li>
                                        <li>Randevu saati: ' . $request->input('saat') . ',</li>
                                        <li>Hesap adı: ' . $request->input('hesap_adi') . ',</li>
                                        <li>Uzmanı: ' . $user->name . '</li>
                                    </ul>
                                <p>şeklinde kayıt tamamlandı.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('visa_appointments')->where("visa_file_id", "=", $visa_file_id)->update([
                    'user_id' => $request->session()->get('userId'),
                    'gwf' => $request->input('gwf'),
                    'name' => $request->input('hesap_adi'),
                    'password' => $request->input('sifre'),
                    'date' => $request->input('tarih'),
                    'time' => $request->input('saat'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Başvuru bekleyen dosyalar aşamasında;</p>
                                    Randevu Bilgileri
                                    <ul>
                                        <li>GWF numarası: ' . $request->input('gwf') . ',</li>
                                        <li>Randevu ofisi: ' . $appointmentOffice->name . ',</li>
                                        <li>Randevu tarihi: ' . $request->input('tarih') . ',</li>
                                        <li>Randevu saati: ' . $request->input('saat') . ',</li>
                                        <li>Hesap adı: ' . $request->input('hesap_adi') . ',</li>
                                        <li>Uzmanı: ' . $user->name . '</li>
                                    </ul>
                                <p>şeklinde kayıt güncellendi.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            if ($request->session()->get('userTypeId') == 1) {
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
                    'appointment_office_id' => $request->input('ofis'),
                    'expert_id' => $request->input('uzman'),
                    'visa_file_grades_id' => $nextGrades,
                ]);
            } else {
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
                    'appointment_office_id' => $request->input('ofis'),
                    'expert_id' => $request->session()->get('userId'),
                    'visa_file_grades_id' => $nextGrades,
                ]);
            }
            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', 'İşlem başarıyla tamamlandı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
