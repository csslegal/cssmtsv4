<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileOpenController extends Controller
{

    public function index($id)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();
        $visaValidities = DB::table('visa_validity')->orderBy('orderby')->get();
        $applicationOffices = DB::table('application_offices')->orderBy('orderby')->get();
        $appointmentOffices = DB::table('appointment_offices')->orderBy('orderby')->get();
        $visaTypes = DB::table('visa_types')->orderBy('orderby')->get();
        $users = DB::table('users')->orderBy('orderby')->get();

        return view('customer.visa.grades.file-open')->with([
            'users' => $users,
            'visaTypes' => $visaTypes,
            'visaValidities' => $visaValidities,
            'baseCustomerDetails' => $baseCustomerDetails,
            'applicationOffices' => $applicationOffices,
            'appointmentOffices' => $appointmentOffices,
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'basvuru_ofis' => 'required|numeric',
            'randevu_ofis' => 'required|numeric',
            'tipi' => 'required|numeric',
            'sure' => 'required|numeric',
            'tc_number' => 'required|min:7',
            'address' => 'required|min:3',
        ]);

        $customerActiveFile = DB::table('visa_files')->where('active', '=', 1)->where('customer_id', '=', $id)->get()->count();

        if ($customerActiveFile == 0) {

            $tipi = $request->input('tipi');
            $sure = $request->input('sure');

            $basvuru_ofis = $request->input('basvuru_ofis');
            $randevu_ofis = $request->input('randevu_ofis');

            $tc_number = $request->input('tc_number');
            $address = mb_convert_case(mb_strtolower($request->get('address')), MB_CASE_TITLE, "UTF-8");

            $visaFileInsertId = DB::table('visa_files')->insertGetId([
                'customer_id' => $id,
                'visa_type_id' => $tipi,
                'visa_validity_id' => $sure,
                'application_office_id' => $basvuru_ofis,
                'appointment_office_id' => $randevu_ofis,
                'visa_file_grades_id' => env('VISA_FILE_OPEN_GRADES_ID'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            do {
                $dosyaRefNumber = rand(10000, 99999);
            } while (DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->count() != 0);

            DB::table('visa_files')->where('id', '=', $visaFileInsertId)->update(['id' => $dosyaRefNumber,]);

            if ($request->session()->get('userTypeId') == 2) {
                $user = DB::table('users')->where('id', '=', $request->session()->get('userId'))->first();
                DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->update(['advisor_id' => $request->session()->get('userId'),]);
            } elseif ($request->session()->get('userTypeId') == 1) {
                $user = DB::table('users')->where('id', '=', $request->input('danisman'))->first();
                DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->update(['advisor_id' => $request->input('danisman'),]);
            }
            DB::table('customers')->where('id', '=', $id)->update(['tc_number' => $tc_number, 'address' =>  $address,]);

            $visaFileGradesName = new VisaFileGradesName(env('VISA_FILE_OPEN_GRADES_ID'));
            $visaType = DB::table('visa_types')->where('id', '=', $tipi)->first();
            $visaValidity = DB::table('visa_validity')->where('id', '=', $sure)->first();
            $applicationOffice = DB::table('application_offices')->where('id', '=', $basvuru_ofis)->first();
            $appointmentOffice = DB::table('appointment_offices')->where('id', '=', $randevu_ofis)->first();


            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $dosyaRefNumber,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => '<p>Müşteri dosyası açma işlemi başlatılıyor aşamasında;</p>
                                <ul>
                                    <li>Vize tipi: ' . $visaType->name . ',</li>
                                    <li>Vize süresi: ' . $visaValidity->name . ',</li>
                                    <li>Kimlik no: ' . $tc_number . ',</li>
                                    <li>Adresi: ' . $address . ',</li>
                                    <li>Başvuru ofisi: ' . $applicationOffice->name . ',</li>
                                    <li>Randevu ofisi: ' . $appointmentOffice->name . ',</li>
                                    <li>Danışmanı: ' . $user->name . '</li>
                                </ul>
                            <p>şeklinde kayıt tamamlandı.</p>',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($dosyaRefNumber);

            DB::table('visa_files')->where("id", "=", $dosyaRefNumber)->update(['visa_file_grades_id' => $nextGrades]);

            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajInfo', 'Müşteri cari dosyası mevcut');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
