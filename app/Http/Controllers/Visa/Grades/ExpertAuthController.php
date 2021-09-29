<?php

namespace App\Http\Controllers\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpertAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select(
                [
                    'customers.id AS id',
                    'visa_files.id AS visa_file_id',
                ]
            )
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('customers.id', '=', $id)->first();

        $experts = DB::table('users')
            ->where('user_type_id', '=', '3')
            ->where('active', '=', 1)
            ->get();

        $visaFilesExperts = DB::table('visa_files')
            ->select(
                [
                    'visa_types.name AS visa_type_name',
                    'visa_files.expert_id AS expert_id',
                    'visa_sub_types.name AS visa_sub_type_name',
                    DB::raw('count(visa_files.visa_sub_type_id) as count'),
                ]
            )
            ->join('visa_sub_types', 'visa_files.visa_sub_type_id', '=', 'visa_sub_types.id')
            ->join('visa_types', 'visa_sub_types.visa_type_id', '=', 'visa_types.id')

            ->groupBy('visa_files.visa_sub_type_id')->get();

        return view('customer.visa.grades.expert-auth')->with(
            [
                'experts' => $experts,
                'baseCustomerDetails' => $baseCustomerDetails,
                'visaFilesExperts' => $visaFilesExperts,
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
    public function store(Request $request,$id,$visa_file_id)
    {
        $request->validate(['uzman' => 'required|numeric',]);

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

            if (DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update(
                    [
                        'visa_file_grades_id' => $nextGrades,
                        'expert_id' => $request->input('uzman'),
                    ]
                )
            ) {
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Uzman ataması yapıldı',
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
