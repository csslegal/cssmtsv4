<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileDeliveryController extends Controller
{

    public function index($id, $visa_file_id, Request $request)
    {
        $applicationOffices = DB::table('application_offices')->get();
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        return view('customer.visa.grades.file-delivery')
            ->with([
                'baseCustomerDetails' => $baseCustomerDetails,
                'applicationOffices' => $applicationOffices,
            ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $validatorStringArray = array('teslimat_sekli' => 'required');

        if ($request->input('teslimat_sekli') == 1) {

            $validatorStringArray = array('ofis' => 'required', 'teslimat_sekli' => 'required',);

            $dataArray = array(
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'application_office_id' => $request->input('ofis'),
                'delivery_method' => $request->input('teslimat_sekli')
            );
        } elseif ($request->input('teslimat_sekli') == 2) {

            $validatorStringArray = array(
                'ofis' => 'required',
                'teslimat_sekli' => 'required',
                'kargo_firmasi' => 'required',
                'kargo_takip_no' => 'required|min:3',
            );

            $dataArray = array(
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'application_office_id' => $request->input('ofis'),
                'delivery_method' => $request->input('teslimat_sekli'),
                'courier_company' => $request->input('kargo_firmasi'),
                'tracking_number' => $request->input('kargo_takip_no')
            );
        } elseif ($request->input('teslimat_sekli') == 3) {

            $validatorStringArray = array('ofis' => 'required', 'teslimat_sekli' => 'required',);

            $dataArray = array(
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'application_office_id' => $request->input('ofis'),
                'delivery_method' => $request->input('teslimat_sekli')
            );
        }

        $request->validate($validatorStringArray);

        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {
            $visaFileDeliveryCount = DB::table('visa_file_delivery')->where('visa_file_id', '=', $visa_file_id)->get()->count();

            if ($visaFileDeliveryCount > 0) {
                $dataArray = array_merge($dataArray, array('updated_at' => date('Y-m-d H:i:s')));
                DB::table('visa_file_delivery')->where("visa_file_id", "=", $visa_file_id)->update($dataArray);
            } else {
                $dataArray = array_merge($dataArray, array('created_at' => date('Y-m-d H:i:s')));
                DB::table('visa_file_delivery')->insert($dataArray);
            }
            DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['active' => 1, 'visa_file_grades_id' => $nextGrades]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $applicationOffice = DB::table('application_offices')->where('id', '=', $request->input('ofis'))->first();

            if ($request->input('teslimat_sekli') == 1) {
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Dosya teslimi bekleyenler aşamasında;</p>
                                    <ul>
                                        <li>Teslim edilme şekli: Elden kimlik ile</li>
                                        <li>Teslim eden ofis: ' . $applicationOffice->name . '</li>
                                    </ul>
                                <p>şeklinde kayıt tamamlandı.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } elseif ($request->input('teslimat_sekli') == 2) {
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Dosya teslimi bekleyenler aşamasında;</p>
                                    <ul>
                                        <li>Teslim edilme şekli: Kargo ile</li>
                                        <li>Teslim eden ofis: ' . $applicationOffice->name . '</li>
                                        <li>Kargo firması: ' . $request->input('kargo_firmasi') . '</li>
                                        <li>Kargo takip no: ' . $request->input('kargo_takip_no') . '</li>
                                    </ul>
                                <p>şeklinde kayıt tamamlandı.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } elseif ($request->input('teslimat_sekli') == 3) {
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Dosya teslimi bekleyenler aşamasında;</p>
                                    <ul>
                                        <li>Teslim edilme şekli: Başvuru yenileme ile</li>
                                        <li>Teslim eden ofis: ' . $applicationOffice->name . '</li>
                                    </ul>
                                <p>şeklinde kayıt tamamlandı.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
