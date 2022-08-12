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
        $request->validate(['basvuru_ofis' => 'required|numeric',
            'randevu_ofis' => 'required|numeric',
            'vize-tipi' => 'required|numeric',
            'vize-sure' => 'required|numeric',
            'tc_number' => 'required|min:7',
            'address' => 'required|min:3',
        ]);

        $customerActiveFile = DB::table('visa_files')->where('active', '=', 1)->where('customer_id', '=', $id)->get()->count();

        if ($customerActiveFile == 0) {

            $visaFileInsertId = DB::table('visa_files')->insertGetId([
                'customer_id' => $id,
                'visa_type_id' => $request->input('vize-tipi'),
                'visa_validity_id' => $request->input('vize-sure'),
                'application_office_id' => $request->input('basvuru_ofis'),
                'appointment_office_id' => $request->input('randevu_ofis'),
                'visa_file_grades_id' => env('VISA_FILE_OPEN_GRADES_ID'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            do {
                $dosyaRefNumber = rand(10000, 99999);
            } while (DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->count() != 0);

            DB::table('visa_files')->where('id', '=', $visaFileInsertId)->update(['id' => $dosyaRefNumber,]);

            if ($request->session()->get('userTypeId') == 2) {
                DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->update(['advisor_id' => $request->session()->get('userId'),]);
            } elseif ($request->session()->get('userTypeId') == 1 || $request->session()->get('userTypeId') == 4 || $request->session()->get('userTypeId') == 7) {
                DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->update(['advisor_id' => $request->input('danisman'),]);
            }
            DB::table('customers')->where('id', '=', $id)->update([
                'tc_number' => $request->input('tc_number'),
                'address' => $request->input('address'),
            ]);

            $visaFileGradesName = new VisaFileGradesName(env('VISA_FILE_OPEN_GRADES_ID'));

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $dosyaRefNumber,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Müşteri dosyası açma işlemi başlatılıyor aşaması tamamlandı',
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
