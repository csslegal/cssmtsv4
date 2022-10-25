<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslationsWaitController extends Controller
{
    public function index($id, $visa_file_id)
    {

        $users = DB::table('users')->orderBy('orderby')->get();

        $baseCustomerDetails = DB::table('customers')->select(['customers.id AS id', 'visa_files.id AS visa_file_id',])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)->where('customers.id', '=', $id)->first();


        return view('customer.visa.grades.translations-completed')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
            'users' => $users,
        ]);
    }

    public function  store($id, $visa_file_id, Request $request)
    {
        if ($request->session()->get('userTypeId') == 1) {
            $validatorStringArray = array(
                'tercuman' => 'required|numeric',
                'sayfa' => 'required|numeric',
                'kelime' => 'required|numeric',
                'karakter' => 'required|numeric',
                'tercume-sayfa' => 'required|numeric',
                'tercume-kelime' => 'required|numeric',
                'tercume-karakter' => 'required|numeric',
            );
        } else {
            $validatorStringArray = array(
                'sayfa' => 'required|numeric',
                'kelime' => 'required|numeric',
                'karakter' => 'required|numeric',
                'tercume-sayfa' => 'required|numeric',
                'tercume-kelime' => 'required|numeric',
                'tercume-karakter' => 'required|numeric',
            );
        }

        $request->validate($validatorStringArray);

        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            if (DB::table('visa_translations')->where('visa_file_id', '=', $visa_file_id)->get()->count() == 0) {

                DB::table('visa_translations')->insert(array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'page' => $request->input('sayfa'),
                    'word' => $request->input('kelime'),
                    'character' => $request->input('karakter'),
                    'translated_page' => $request->input('tercume-sayfa'),
                    'translated_word' => $request->input('tercume-kelime'),
                    'translated_character' => $request->input('tercume-karakter'),
                    'created_at' => date('Y-m-d H:i:s'),
                ));
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Tercüme bekleyen dosyalar aşamasında;</p>
                                    Orjinal Belge Bilgileri
                                    <ul>
                                        <li>Sayfa sayısı: ' . $request->input('sayfa') . ',</li>
                                        <li>Kelime sayısı: ' . $request->input('kelime') . ',</li>
                                        <li>Karakter sayısı: ' . $request->input('karakter') . '</li>
                                    </ul>
                                    Tercüme Belge Bilgileri
                                    <ul>
                                        <li>Sayfa sayısı: ' . $request->input('tercume-sayfa') . ',</li>
                                        <li>Kelime sayısı: ' . $request->input('tercume-kelime') . ',</li>
                                        <li>Karakter sayısı: ' . $request->input('tercume-karakter') . '</li>
                                    </ul>
                                <p>şeklinde kayıt tamamlandı.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('visa_translations')->where("visa_file_id", "=", $visa_file_id)->update([
                    'user_id' => $request->session()->get('userId'),
                    'page' => $request->input('sayfa'),
                    'word' => $request->input('kelime'),
                    'character' => $request->input('karakter'),
                    'translated_page' => $request->input('tercume-sayfa'),
                    'translated_word' => $request->input('tercume-kelime'),
                    'translated_character' => $request->input('tercume-karakter'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => '<p>Tercüme bekleyen dosyalar aşamasında;</p>
                                    Orjinal Belge Bilgileri
                                    <ul>
                                        <li>Sayfa sayısı: ' . $request->input('sayfa') . ',</li>
                                        <li>Kelime sayısı: ' . $request->input('kelime') . ',</li>
                                        <li>Karakter sayısı: ' . $request->input('karakter') . '</li>
                                    </ul>
                                    Tercüme Belge Bilgileri
                                    <ul>
                                        <li>Sayfa sayısı: ' . $request->input('tercume-sayfa') . ',</li>
                                        <li>Kelime sayısı: ' . $request->input('tercume-kelime') . ',</li>
                                        <li>Karakter sayısı: ' . $request->input('tercume-karakter') . '</li>
                                    </ul>
                                <p>şeklinde kayıt güncellendi.</p>',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            if ($request->session()->get('userTypeId') == 1) {
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
                    'visa_file_grades_id' => $nextGrades,
                    'translator_id' => $request->input('tercuman'),
                ]);
            } else {
                DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
                    'visa_file_grades_id' => $nextGrades,
                    'translator_id' => $request->session()->get('userId')
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

    public function index_islemsiz($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {

            DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Tercümeler tamamlandı',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $request->session()->flash('mesajSuccess', 'Tercümeler tamamlandı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajDanger', 'Sonraki vize aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
