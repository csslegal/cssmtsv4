<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesUpdateController extends Controller
{

    public function store(Request $request, $id, $visa_file_id)
    {
        $lastVisaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $lastVisaFileGradesName = new VisaFileGradesName($lastVisaFileGradesId->visa_file_grades_id);
        $nextVisaFileGradesName = new VisaFileGradesName($request->input('visa_file_grades_id'));

        if (DB::table('visa_files')->where('id', '=', $visa_file_id)->update(['visa_file_grades_id' => $request->input('visa_file_grades_id'), 'updated_at' => date('Y-m-d H:i:s')])) {

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => 'Dosya aşama güncelleme',
                'content' => '<b>' . $lastVisaFileGradesName->getName() . '</b> aşamasından <b>' . $nextVisaFileGradesName->getName() . '</b> aşamasına güncelemesi yapıldı',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $request->session()->flash('mesajSuccess', 'Güncelleme başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/');
        } else {

            $request->session()->flash('mesajDanger', 'Güncelleme sırasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/');
        }
    }
}
