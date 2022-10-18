<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaFileGradesUsersTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('users_type')
            ->select(
                'users_type.id AS id',
                'users_type.name AS ut_name',
                'visa_file_grades_users_type.created_at AS created_at',
                'visa_file_grades_users_type.updated_at AS updated_at',
            )
            ->join('visa_file_grades_users_type', 'users_type.id', '=', 'visa_file_grades_users_type.user_type_id')
            ->distinct()
            ->get();

        return view('management.visa.file-grades-users-type.index')->with([
            'kayitlar' => $kayitlar
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usersTypes = DB::table('users_type')->get();
        $visaFileGrades = DB::table('visa_file_grades')->orderBy('orderby')->get();

        return view('management.visa.file-grades-users-type.create')->with([
            'usersTypes' => $usersTypes,
            'visaFileGrades' => $visaFileGrades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tip = $request->input('tip');
        $visaFileGrade = $request->input('dosya-asamalari');

        $request->validate([
            'tip' => 'required|numeric',
        ]);
        if (count((array)$visaFileGrade) > 0) {

            $arrayVisaFileGrade = array();
            foreach ($visaFileGrade as $visaFileGrade) {
                $arrayVisaFileGrade = array_merge(
                    $arrayVisaFileGrade,
                    array([
                        'user_type_id' => $tip,
                        'visa_file_grade_id' => $visaFileGrade,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ])
                );
            }
            DB::table('visa_file_grades_users_type')->where('user_type_id', '=', $tip)->delete();
            DB::table('visa_file_grades_users_type')->insert($arrayVisaFileGrade);

            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/vize/dosya-asama-erisim');
        } else {
            $request->session()->flash('mesajDanger', 'En az bir dosya aşaması seçimi yapınız');
            return redirect('yonetim/vize/dosya-asama-erisim/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usersTypes = DB::table('users_type')->get();
        $visaFileGrades = DB::table('visa_file_grades')->orderBy('orderby')->get();

        $fileGradesUsersType = DB::table('visa_file_grades_users_type')
            ->select('visa_file_grade_id')
            ->where('user_type_id', '=', $id)
            ->get()->pluck('visa_file_grade_id')->toArray();

        $kayit = DB::table('users_type')->where('id', '=', $id)->first();

        return view('management.visa.file-grades-users-type.edit')->with([
            'kayit' => $kayit,
            'usersTypes' => $usersTypes,
            'visaFileGrades' => $visaFileGrades,
            'fileGradesUsersType' => $fileGradesUsersType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $tip = $request->input('tip');
        $visaFileGrades = $request->input('dosya-asamalari');

        $request->validate([
            'tip' => 'required|numeric',
            'dosya-asamalari' => 'required',
        ]);

        if (count((array)$visaFileGrades) > 0) {

            DB::table('visa_file_grades_users_type')->where('user_type_id', '=', $id)->delete();

            $arrayVisaFileGrade = array();

            foreach ($visaFileGrades as $visaFileGrade) {
                $arrayVisaFileGrade = array_merge(
                    $arrayVisaFileGrade,
                    array([
                        'user_type_id' => $tip,
                        'visa_file_grade_id' => $visaFileGrade,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ])
                );
            }
            DB::table('visa_file_grades_users_type')->insert($arrayVisaFileGrade);

            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/vize/dosya-asama-erisim');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (is_numeric($id)) {

            if (DB::table('visa_file_grades_users_type')->where('user_type_id', '=', $id)->delete()) {

                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/vize/dosya-asama-erisim');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/vize/dosya-asama-erisim');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/dosya-asama-erisim');
        }
    }
}
