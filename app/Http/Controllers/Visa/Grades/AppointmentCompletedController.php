<?php

namespace App\Http\Controllers\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentCompletedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id)
    {

        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $times = DB::table('times')->get();

        return view('customer.visa.grades.appointment-completed')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'times' => $times,
                ]
            );
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
        $validatorStringArray = array(
            'gwf' => 'required',
            'hesap_adi' => 'required',
            'sifre' => 'required',
            'tarih' => 'required',
            'saat' => 'required',
        );

        $request->validate($validatorStringArray);


        $customerAppointmentCount = DB::table('visa_appointments')
            ->where('visa_file_id', '=', $visa_file_id)
            ->get()->count();

        if ($customerAppointmentCount == 0) {

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            if ($nextGrades != null) {

                $insertDataArray = array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'gwf' => $request->input('gwf'),
                    'name' => $request->input('hesap_adi'),
                    'password' => $request->input('sifre'),
                    'date' => $request->input('tarih'),
                    'time' => $request->input('saat'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                if (DB::table('visa_appointments')->insert($insertDataArray)) {

                    DB::table('visa_files')
                        ->where("id", "=", $visa_file_id)
                        ->update(['visa_file_grades_id' => $nextGrades]);

                    DB::table('visa_file_logs')->insert([
                        'visa_file_id' => $visa_file_id,
                        'user_id' => $request->session()->get('userId'),
                        'subject' => $visaFileGradesName->getName(),
                        'content' => 'Randevu bilgisi kaydedildi',
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);

                    $request->session()
                        ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                    return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/alinan-odeme');
                } else {
                    $request->session()
                        ->flash('mesajDanger', 'Kayıt sırasında sorun oluştu');
                    return redirect('/musteri/' . $id . '/vize' );
                }
            } else {
                $request->session()
                ->flash('mesajDanger', 'Sonraki aşama bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
            }
        } else {
            //form kaydını güncelleme burdan devam edecek
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
