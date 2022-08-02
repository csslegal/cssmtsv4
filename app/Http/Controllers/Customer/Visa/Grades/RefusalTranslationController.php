<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefusalTranslationController extends Controller
{
    public function index($id, $visa_file_id)
    {
        $refusalTranslation = DB::table('visa_refusal_translation')
        ->where('visa_file_id', '=', $visa_file_id)->first();
        $baseCustomerDetails = DB::table('customers')->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        return view('customer.visa.grades.refusal-translation')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'refusalTranslation' => $refusalTranslation,
        ]);
    }

    public function store(Request $request, $id, $visa_file_id)
    {
        $validatorStringArray = array(
            'sayfa_sayisi' => 'required',
            'tercume_sayfa_sayisi' => 'required',
            'tercume_kelime_sayisi' => 'required',
            'tercume_karakter_sayisi' => 'required',
        );

        $request->validate($validatorStringArray);

        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)
            ->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        DB::table('visa_files')->where("id", "=", $visa_file_id)
            ->update([
                'visa_file_grades_id' => env('VISA_FILE_DELIVERY_GRADES_ID')
            ]);

        if ($request->session()->has($visa_file_id . '_grades_id')) {
            $request->session()->forget($visa_file_id . '_grades_id');
        }

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Vize red tercüme bilgisi kaydedildi',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $visaRefusalTranslation = DB::table('visa_refusal_translation')
            ->where('visa_file_id', '=', $visa_file_id)
            ->get();

        if ($visaRefusalTranslation->count() == 0) {

            DB::table('visa_refusal_translation')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'page_count' => $request->input('sayfa_sayisi'),
                'translate_page_count' => $request->input('tercume_sayfa_sayisi'),
                'translate_word_count' => $request->input('tercume_kelime_sayisi'),
                'translate_character_count' => $request->input('tercume_karakter_sayisi'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            DB::table('visa_refusal_translation')
                ->where('id', '=', $visaRefusalTranslation[0]->id)
                ->update([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'page_count' => $request->input('sayfa_sayisi'),
                    'translate_page_count' => $request->input('tercume_sayfa_sayisi'),
                    'translate_word_count' => $request->input('tercume_kelime_sayisi'),
                    'translate_character_count' => $request->input('tercume_karakter_sayisi'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }

        $request->session()
            ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/musteri/' . $id . '/vize');

        $request->session()
            ->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
        return redirect('/musteri/' . $id . '/vize');
    }
}
