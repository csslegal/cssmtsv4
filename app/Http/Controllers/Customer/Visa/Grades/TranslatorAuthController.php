<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslatorAuthController extends Controller
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

        $translators = DB::table('users')
            ->where('user_type_id', '=', '5')
            ->where('active', '=', 1)
            ->get();

        $visaFilesTranslators = DB::table('visa_files')
            ->select([
                'visa_types.name AS visa_type_name',
                'visa_files.translator_id AS translator_id',
                'visa_sub_types.name AS visa_sub_type_name',
                'visa_sub_types.id AS visa_sub_type_id',
            ])
            ->join('visa_sub_types', 'visa_files.visa_sub_type_id', '=', 'visa_sub_types.id')
            ->join('visa_types', 'visa_sub_types.visa_type_id', '=', 'visa_types.id')
            ->where('visa_files.visa_file_grades_id', '<=', env('VISA_TRANSLATION_GRADES_ID'))
            ->where('visa_files.active', '=', 1)
            ->get();

        return view('customer.visa.grades.translator-auth')->with([
            'translators' => $translators,
            'baseCustomerDetails' => $baseCustomerDetails,
            'visaFilesTranslators' => $visaFilesTranslators,
        ]);
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $request->validate(['tercuman' => 'required|numeric',]);

        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update([
                    'visa_file_grades_id' => $nextGrades,
                    'translator_id' => $request->input('tercuman'),
                ])
            ) {

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }

                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Tercüman ataması yapıldı',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
