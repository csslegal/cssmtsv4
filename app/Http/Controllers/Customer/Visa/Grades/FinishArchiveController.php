<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinishArchiveController extends Controller
{

    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        return view('customer.visa.grades.finish-archive')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $request->validate([
            'folder_name' => 'required',
        ]);

        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
            'active' => 0,
            'archive_folder_name' =>  $request->input('folder_name'),
        ]);

        if ($request->session()->has($visa_file_id . '_grades_id')) {
            $request->session()->forget($visa_file_id . '_grades_id');
        }

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Vize dosyası, arşiv bilgisi kayıt altına alındı ',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/musteri/' . $id . '/vize');
    }
}
