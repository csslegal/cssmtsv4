<?php

namespace App\MyClass;

use Illuminate\Support\Facades\DB;


class VisaFileWhichGrades
{
    public function lastGrades($id)
    {
        $visaFileGradesDetail = DB::table('visa_files')
            ->select(["visa_file_grades.orderby AS orderby",])
            ->join("visa_file_grades", 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->where("visa_files.id", '=', $id)
            ->first();

        /**onceki değeri bulmak için kendisinden kucukleri alıp en buyugu geriye dondermek ile sorun giderilmiş oldu*/
        $lastVisaFileGrades = DB::table('visa_file_grades')
            ->select("id")
            ->where('orderby', '<', $visaFileGradesDetail->orderby)
            ->orderBy('orderby', 'DESC')
            ->limit(1)
            ->get();
        return count($lastVisaFileGrades) > 0 ? $lastVisaFileGrades[0]->id : null;
    }

    public function nextGrades($id)
    {
        $visaFileGradesDetail = DB::table('visa_files')
            ->select(["visa_file_grades.orderby AS orderby",])
            ->join("visa_file_grades", 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->where('visa_files.id', '=', $id)
            ->first();
        //dd($visaFileGradesDetail);
        /** sonraki değeri bulmak için kendisinden buyukleri alıp en kucugu geriye dondermek ile sorun giderilmiş oldu*/
        $lastVisaFileGrades = DB::table('visa_file_grades')
            ->select("id")
            ->where('orderby', '>', $visaFileGradesDetail->orderby)
            ->orderBy('orderby', 'ASC')
            ->limit(1)
            ->get();
        return count($lastVisaFileGrades) > 0 ? $lastVisaFileGrades[0]->id : null;
    }
}
