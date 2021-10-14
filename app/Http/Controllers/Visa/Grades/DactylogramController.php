<?php

namespace App\Http\Controllers\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DactylogramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        return view('customer.visa.grades.dactylogram')
            ->with([
                'baseCustomerDetails' => $baseCustomerDetails,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, $visa_file_id, Request $request)
    {


        if ($request->has('tamam')) {
            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Parmak izi verildi',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            if ($nextGrades != null) {

                if (DB::table('visa_files')
                    ->where("id", "=", $visa_file_id)
                    ->update(['visa_file_grades_id' => $nextGrades])
                ) {
                    $request->session()
                        ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                    return redirect('/musteri/' . $id . '/vize');
                } else {
                    $request->session()
                        ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize');
                }
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
        if ($request->has('ertele')) {
            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Randevu ertelendi',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update(['visa_file_grades_id' => env('VISA_APPOINTMENT_PUTOFF_GRADES_ID')])
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');

                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('/musteri/' . $id . '/vize');
            }
        }
        if ($request->has('iptal')) {
            dd('iptal');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
