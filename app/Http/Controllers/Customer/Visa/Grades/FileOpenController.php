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
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $visaValidities = DB::table('visa_validity')->orderBy('orderby')->get();
        $visaTypes = DB::table('visa_types')->orderBy('orderby')->get();
        $language = DB::table('language')->orderBy('orderby')->get();
        $users = DB::table('users')->orderBy('orderby')->get();

        return view('customer.visa.grades.file-open')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'visaTypes' => $visaTypes,
                    'language' => $language,
                    'users' => $users,
                    'visaValidities' => $visaValidities,

                ]
            );
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        $request->validate(
            [
                'vize-tipi' => 'required|numeric',
                'vize-sure' => 'required|numeric',
                'tc-no' => 'required|min:7',
                'adres' => 'required|min:3',
            ]
        );

        $customerActiveFile = DB::table('visa_files')
            ->where('active', '=', 1)
            ->where('customer_id', '=', $id)
            ->get()->count();

        if ($customerActiveFile == 0) {

            $visaFileInsertId = DB::table('visa_files')->insertGetId(
                [
                    'customer_id' => $id,
                    'visa_sub_type_id' => $request->input('vize-tipi'),
                    'visa_validity_id' => $request->input('vize-sure'),
                    'visa_file_grades_id' => env('VISA_FILE_OPEN_GRADES_ID'),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            do {
                $dosyaRefNumber = rand(10000, 99999);
            } while (DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->count() != 0);

            DB::table('visa_files')
                ->where('id', '=', $visaFileInsertId)
                ->update(['id' => $dosyaRefNumber,]);

            if ($request->session()->get('userTypeId') == 2) {

                DB::table('visa_files')
                    ->where('id', '=', $dosyaRefNumber)
                    ->update(['advisor_id' => $request->session()->get('userId'),]);
            } elseif (

                $request->session()->get('userTypeId') == 1 ||
                $request->session()->get('userTypeId') == 4 ||
                $request->session()->get('userTypeId') == 7
            ) {
                DB::table('visa_files')
                    ->where('id', '=', $dosyaRefNumber)
                    ->update(['advisor_id' => $request->input('danisman'),]);
            }
            DB::table('customers')->where('id', '=', $id)->update(
                [
                    'tcno' => $request->input('tc-no'),
                    'adres' => $request->input('adres'),
                ]
            );

            $visaFileGradesName = new VisaFileGradesName(env('VISA_FILE_OPEN_GRADES_ID'));

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $dosyaRefNumber,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($dosyaRefNumber);

            DB::table('visa_files')
            ->where("id", "=", $dosyaRefNumber)
            ->update(['visa_file_grades_id' => $nextGrades]);

            $request->session()
                ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()
                ->flash('mesajInfo', 'Müşteri cari dosyası mevcut.');
            return redirect('/musteri/' . $id . '/vize');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
